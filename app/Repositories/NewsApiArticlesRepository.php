<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\ArticlesCollection;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class NewsApiArticlesRepository implements ArticlesRepository
{
    private Client $httpClient;

    public function __construct()
    {
        $this->httpClient = new Client([
            'base_uri' => $_ENV['NEWS_API_URL']
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public function getAllByCategory(string $category): ArticlesCollection
    {
        $url = "top-headlines?country=us&category=$category&apiKey={$_ENV['NEWS_API_KEY']}";
        $apiResponse = json_decode($this->httpClient->get($url)->getBody()->getContents());
        $articles = [];
        foreach ($apiResponse->articles as $article) {
            $articles[] = new Article(
                (string)$article->title,
                (string)$article->description,
                (string)$article->url,
                (string)$article->urlToImage,
            );
        }
        return new ArticlesCollection($articles);
    }
}