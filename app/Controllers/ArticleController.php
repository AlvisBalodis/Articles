<?php

namespace App\Controllers;

use App\Services\ShowAllArticlesService;
use App\Services\StoreArticleService;
use App\Services\StoreArticleServiceRequest;
use App\View;
use Doctrine\DBAL\Exception;

class ArticleController
{
    private ShowAllArticlesService $service;
    private StoreArticleService $storeArticleService;

    public function __construct(ShowAllArticlesService $service, StoreArticleService $storeArticleService)
    {
        $this->service = $service;
        $this->storeArticleService = $storeArticleService;
    }

    public function index(): View
    {
        $category = $_GET['category'] ?? 'general';
        return new View('articles', [
            'articles' => $this->service->execute($category)->getAll()
        ]);
    }

    /**
     * @throws Exception
     */
    public function store(): void
    {
        $this->storeArticleService->store(
            new StoreArticleServiceRequest(
                $_POST['title'],
                $_POST['description'],
                $_POST['url'],
                $_POST['image']
            ));
        header('Location: /articles/favorite-articles');
    }

    /**
     * @throws Exception
     */
    public function delete(): void
    {
        $this->storeArticleService->delete(
            new StoreArticleServiceRequest(
                $_POST['title'],
                $_POST['description'],
                $_POST['url'],
                $_POST['image']
            ));
        header('Location: /articles/favorite-articles');
    }

    /**
     * @throws Exception
     */
    public function create(): View
    {
        $favoriteArticles = $this->storeArticleService->execute()->getAll();
        return new View('favoriteArticles', [
            'articles' => $favoriteArticles
        ]);
    }
}