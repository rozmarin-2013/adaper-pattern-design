<?php

interface NewsApiClientInterface
{
    public function getEverything(
        string $query,
        DateTime $fromDate,
        DateTime $toDate, // you don't need this param
        int $pageSize,
        int $page // and this too
    ): array;
}