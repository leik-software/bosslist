<?php
declare(strict_types=1);

namespace App\Helper;

use TextAnalysis\Collections\DocumentArrayCollection;
use TextAnalysis\Documents\TokensDocument;
use TextAnalysis\Indexes\TfIdf;
use TextAnalysis\NGrams\NGramFactory;

final class StringSimilarityHelper
{
    public static function stringSimilarity(string $left, string $right, float $treshold = 0.9): bool
    {
        if($left === $right){
            return true;
        }
        $left = self::sortStringByWords(preg_replace('/[^A-Za-z0-9 ]/', ' ', $left));
        $right = self::sortStringByWords(preg_replace('/[^A-Za-z0-9 ]/', ' ', $right));
        $leftNgrams = (NGramFactory::create(mb_str_split($left), 3, ''));
        $rightNgrams = (NGramFactory::create(mb_str_split($right), 3, ''));
        if(!array_intersect($leftNgrams, $rightNgrams)){
            return false;
        }

        $triGrams = array_unique(array_merge($leftNgrams, $rightNgrams));
        $termFrequencyLeft = self::calcTermFrequency($leftNgrams, $triGrams);
        $termFrequencyRight = self::calcTermFrequency($rightNgrams, $triGrams);
        $idfs = self::getIdfs($triGrams);

        $vectorLeft = [];
        $vectorRight = [];
        foreach ($idfs as $ngram => $idf) {
            $vectorLeft[] = \in_array($ngram, $leftNgrams, true) ? $idf * $termFrequencyLeft[$ngram] : 0;
            $vectorRight[] = \in_array($ngram, $rightNgrams, true) ? $idf * $termFrequencyRight[$ngram] : 0;
        }
        try{
            return self::getCosineSimilarity($vectorLeft, $vectorRight) >= $treshold;
        }catch (\Throwable){
            return false;
        }
    }

    private static function sortStringByWords(string $string): string
    {
        $array = explode(' ',strtolower($string));
        $array = array_unique($array);
        sort($array);
        return implode(' ',$array);
    }

    private static function getCosineSimilarity(array $tokensLeft, array $tokensRight): float
    {
        return self::dotp($tokensLeft,$tokensRight)/sqrt(self::dotp($tokensLeft,$tokensLeft)*self::dotp($tokensRight,$tokensRight));
    }

    private static function dotp($arr1, $arr2): float|int
    {
        return array_sum(array_map(static function($a, $b){return $a * $b;}, $arr1, $arr2));
    }

    private static function getIdfs(array $ngrams): array
    {
        $output=[];
        foreach($ngrams as $ngram){
            if(!isset($output[$ngram])) {
                $output[$ngram] = 0;
            }
            $output[$ngram]++;
        }

        $count = count($ngrams);
        foreach($output as &$value) {
            $value = log(($count)/($value));
        }

        return $output;

    }

    private static function calcTermFrequency(array $ngrams, array $documentNgrams): array
    {
        $output = [];
        $contentDocument = new TokensDocument($ngrams);
        $tfIdf = new TfIdf(new DocumentArrayCollection([$contentDocument]));
        foreach ($documentNgrams as $ngram) {
            $output[$ngram] = $tfIdf->getTermFrequency($contentDocument, $ngram);
        }

        return $output;
    }
}
