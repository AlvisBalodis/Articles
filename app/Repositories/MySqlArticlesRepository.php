<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\ArticlesCollection;
use App\Services\StoreArticleServiceRequest;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;

class MySqlArticlesRepository
{
    private Connection $connection;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $connectionParams = [
            'dbname' => 'news',
            'user' => 'root',
            'password' => 'password',
            'host' => 'localhost',
            'driver' => 'pdo_mysql'
        ];

        $this->connection = DriverManager::getConnection($connectionParams);
    }

    /**
     * @throws Exception
     */
    public function save(StoreArticleServiceRequest $article): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder->insert('articles')
            ->values([
                'title' => ':title',
                'description' => ':description',
                'url' => ':url',
                'image' => ':image'
            ])
            ->setParameters([
                'title' => $article->getTitle(),
                'description' => $article->getDescription(),
                'url' => $article->getUrl(),
                'image' => $article->getImage()
            ])
            ->executeQuery();
    }

    /**
     * @throws Exception
     */
    public function delete(StoreArticleServiceRequest $article): void
    {
        $connectionParams = [
            'dbname' => 'news',
            'user' => 'root',
            'password' => 'password',
            'host' => 'localhost',
            'driver' => 'pdo_mysql',
        ];

        $conn = DriverManager::getConnection($connectionParams);

        $conn->delete('articles', [
            'title' => $article->getTitle(),
            'description' => $article->getDescription(),
            'url' => $article->getUrl(),
            'image' => $article->getImage()
        ]);
    }

    /**
     * @throws Exception
     */
    public function favoriteArticlesCollection(): ArticlesCollection
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $articlesQuery = $queryBuilder
            ->select('*')
            ->from('articles')
            ->orderBy('created_at', 'DESC')
            ->executeQuery()
            ->fetchAllAssociative();

        $favoriteArticles = [];
        foreach ($articlesQuery as $article) {
            $favoriteArticles[] = new Article(
                (string)$article['title'],
                (string)$article['description'],
                (string)$article['url'],
                (string)$article['image'],
                $article['id']
            );
        }
        return new ArticlesCollection($favoriteArticles);
    }
}