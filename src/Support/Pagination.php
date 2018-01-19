<?php

namespace SF\Support;

use SF\Context\ContextTrait;

class Pagination
{

    use ContextTrait;

    const TOTAL_COUNT_HEADER  = 'X-Pagination-Total-Count';
    const PAGE_COUNT_HEADER   = 'X-Pagination-Page-Count';
    const CURRENT_PAGE_HEADER = 'X-Pagination-Current-Page';
    const PER_PAGE_HEADER     = 'X-Pagination-Per-Page';

    private $page;
    private $limit      = 20;
    private $pageCount;
    private $totalCount = 0;

    public function __construct(int $totalCount = 0)
    {
        $this->totalCount = $totalCount;
    }

    public function getPage()
    {
        if ($this->page === null) {
            $this->page = (int) $this->getRequestContext()->getRequest()->getQueryParam('page');
            if ($this->page > 0) {
                $this->page -= 1;
            }
        }

        return $this->page;
    }

    public function setLimit(int $limit)
    {
        $this->limit = $limit;
    }

    public function getLimit()
    {
        return $this->limit < 1 ? -1 : $this->limit;
    }

    public function getOffset()
    {
        return $this->limit < 1 ? 0 : $this->getPage() * $this->limit;
    }

    public function setTotalCount(int $totalCount)
    {
        $this->totalCount = $totalCount;
        return $this;
    }

    public function getTotalCount()
    {
        return $this->totalCount;
    }

    public function setPageCount(int $count)
    {
        $this->pageCount = $count;
        return $this;
    }

    public function getPageCount()
    {
        if ($this->pageCount === null) {
            $limit = $this->getLimit();
            if ($limit < 1) {
                $this->pageCount = $this->totalCount > 0 ? 1 : 0;
            } else {
                $totalCount = $this->totalCount < 0 ? 0 : (int) $this->totalCount;

                $this->pageCount = (int) (($totalCount + $limit - 1) / $limit);
            }
        }
        return $this->pageCount;
    }

    public function serialize(array $data)
    {
        $response = $this->getRequestContext()->getResponse();
        $response->withHeader(self::TOTAL_COUNT_HEADER, $this->getTotalCount())
                ->setHeader(self::PAGE_COUNT_HEADER, $this->getPageCount())
                ->setHeader(self::CURRENT_PAGE_HEADER, $this->getPage() + 1)
                ->setHeader(self::PER_PAGE_HEADER, $this->getLimit());


        return [
            'items' => $data,
            'meta'  => [
                'totalCount'  => $this->getTotalCount(),
                'pageCount'   => $this->getPageCount(),
                'currentPage' => $this->getPage() + 1,
                'perPage'     => $this->getLimit(),
            ]
        ];
    }

}
