<?php

declare(strict_types=1);

namespace App\Services\Article;

use App\Collections\ArticleCollections;
use App\Repositories\ArticleRepository;



class IndexArticleService
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }


    public function execute(): ArticleCollections
    {
        return $this->articleRepository->getAll();
    }

}