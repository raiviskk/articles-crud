<?php

declare(strict_types=1);

namespace App\Controllers;


use App\RedirectResponse;
use App\Response;
use App\Services\Article\DeleteArticleService;
use App\Services\Article\IndexArticleService;
use App\Services\Article\ShowArticleService;
use App\Services\Article\StoreArticleService;
use App\Services\Article\UpdateArticleService;
use App\ViewResponse;

class ArticleController
{
    private IndexArticleService $indexArticleService;
    private StoreArticleService $storeArticleService;
    private ShowArticleService $showArticleService;
    private UpdateArticleService $updateArticleService;
    private DeleteArticleService $deleteArticleService;

    public function __construct(
        IndexArticleService $indexArticleService,
        StoreArticleService $storeArticleService,
        ShowArticleService $showArticleService,
        UpdateArticleService $updateArticleService,
        DeleteArticleService $deleteArticleService
    )
    {
        $this->indexArticleService = $indexArticleService;
        $this->storeArticleService = $storeArticleService;
        $this->showArticleService = $showArticleService;
        $this->updateArticleService = $updateArticleService;
        $this->deleteArticleService = $deleteArticleService;
    }

    public function index(): Response
    {

        $articlesCollection = $this->indexArticleService->execute();
        return new ViewResponse('articles/index', ['articles' => $articlesCollection]);
    }


    public function show(int $id): Response
    {

        $article = $this->showArticleService->execute($id);

        return new ViewResponse('articles/show',['article' => $article]);
    }

    public function create(): Response
    {
        return new ViewResponse('articles/create');
    }

    public function store(): RedirectResponse
    {

        $this->storeArticleService->execute($_POST['title'], $_POST['description']);

        return new RedirectResponse('/articles');
    }

    public function edit(int $id): ViewResponse
    {

        $article = $this->showArticleService->execute($id);

        return new ViewResponse('articles/edit',['article' => $article]);
    }

    public function update(int $id): RedirectResponse
    {

        $this->updateArticleService->execute($id, $_POST['title'], $_POST['description']);

        return new RedirectResponse('/articles');



    }

    public function delete(int $id): RedirectResponse
    {

        $this->deleteArticleService->execute($id);

        return new RedirectResponse('/articles');
    }
}
