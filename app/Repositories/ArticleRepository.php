<?php

namespace App\Repositories;

use App\Collections\ArticleCollections;
use App\Models\Article;

interface ArticleRepository
{
    public function getById(int $id): ?Article;
    public function getAll(): ArticleCollections;
    public function save(Article $article): void;
    public function delete(Article $article): void;
}
