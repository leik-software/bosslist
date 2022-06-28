<?php
declare(strict_types=1);

namespace App\Collection\Model;

use System\Helper\StringHelper;

final class ReviewModel
{
    private string $author='';
    private string $source='';
    private string $review='';

    private function __construct()
    {
    }

    public static function fromArray(array $row): self
    {
        $self = new static();
        $self->author = $row['author'];
        $self->source = $row['source'];
        if(empty($self->author)){
            $self->review = $row['review'];
        }else{
            $self->review = str_replace(['"','»','«','›'],'', $row['review']);
        }
        return $self;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function getReview(): string
    {
        return $this->review;
    }

}
