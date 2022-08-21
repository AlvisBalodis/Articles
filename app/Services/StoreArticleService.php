<?php

namespace App\Services;

use App\Models\ArticlesCollection;
use App\Repositories\MySqlArticlesRepository;
use Doctrine\DBAL\Exception;

class StoreArticleService
{
    private MySqlArticlesRepository $mySqlArticlesRepository;

    public function __construct(MySqlArticlesRepository $mySqlArticlesRepository)
    {
        $this->mySqlArticlesRepository = $mySqlArticlesRepository;
    }

    /**
     * @throws Exception
     */
    public function store(StoreArticleServiceRequest $storeArticleServiceRequest): void
    {
        $this->mySqlArticlesRepository->save($storeArticleServiceRequest);
    }

    /**
     * @throws Exception
     */
    public function delete(StoreArticleServiceRequest $storeArticleServiceRequest): void
    {
        $this->mySqlArticlesRepository->delete($storeArticleServiceRequest);
    }

    /**
     * @throws Exception
     */
    public function execute(): ArticlesCollection
    {
        return $this->mySqlArticlesRepository->favoriteArticlesCollection();
    }
}