<?php

namespace NewsApi;

use NewsDto;

class NewsApiClientAdapter implements NewsClientInterface
{
    private NewsApiClientInterface $newsApiClient;

    public function __construct(NewsApiClientInterface $newsApiClient)
    {
        $this->newsApiClient = $newsApiClient;
    }

    /**
     * @inheritDoc
     */
    public function search(string $query, DateTime $fromDate, int $limit): array
    {
        $toDate = (new DateTime())->modify('+ 100 years');

        try {
            $newsArr = $this->newsApiClient->getEverything($query, $fromDate, $toDate, $limit, 1);
            $newsDtosArr = [];

            foreach ($newsArr as $newsItem) {
                $newsDtosArr[] = new NewsDto(
                    $newsItem['source']['name'],
                    $newsItem['author'] ?? 'No author',
                    $newsItem['title'],
                    $newsItem['description'],
                    $newsItem['content'],
                    $newsItem['url'],
                    new DateTime($newsItem['publishedAt']),
                );
            }

            return $newsDtosArr;
        } catch (Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }
}