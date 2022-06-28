<?php

declare(strict_types=1);

namespace App\TwigExtension;

use App\ShopRequest;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class AggregationTwigExtension extends AbstractExtension
{
    public function __construct(
        private readonly ShopRequest $shopRequest
    ) {}

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getFilterQueryWithExcludedAggregation', [$this, 'getFilterQueryWithExcludedAggregation']),
            new TwigFunction('addAggregationToFilterQuery', [$this, 'addAggregationToFilterQuery']),
        ];
    }

    public function getFilterQueryWithExcludedAggregation(string $aggregationName): string
    {
        $queryData = $this->shopRequest->getRequest()->query->all();
        unset($queryData[$aggregationName], $queryData['p']);

        return http_build_query($queryData);
    }

    public function addAggregationToFilterQuery(string $aggregationName, string $aggregationValue): string
    {
        $queryData = $this->shopRequest->getRequest()->query->all();
        $queryData[$aggregationName] = $aggregationValue;
        unset($queryData['p']);

        return http_build_query($queryData);
    }
}
