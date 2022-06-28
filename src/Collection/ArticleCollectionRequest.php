<?php

declare(strict_types=1);

namespace App\Collection;

final class ArticleCollectionRequest
{
    private int $limit;
    private int $page;
    private bool $isAjax;
    private bool $isInfiniteScroll;

    public function __construct(int $limit, int $page, bool $isInfiniteScroll, bool $isAjax)
    {
        $this->limit = $limit;
        $this->page = $page;
        $this->isAjax = $isAjax;
        $this->isInfiniteScroll = $isInfiniteScroll;
    }

    public function getLimit(): int
    {
        if($this->isInfiniteScroll && !$this->isAjax){
            return $this->limit*$this->page;
        }
        return $this->limit;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getOffset(): int
    {
        if($this->isAjax){
            return $this->getLimit() * ($this->getPage() - 1);
        }
        if($this->isInfiniteScroll){
            return 0;
        }
        return $this->getLimit() * ($this->getPage() - 1);
    }
}
