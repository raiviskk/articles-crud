<?php

require_once __DIR__ . '/../app/repositories/MsqArticleRepository.php';
require_once __DIR__ . '/../app/Database/DbConnection.php';
require_once __DIR__ . '/../app/Services/Article/IndexArticleService.php';


use App\Repositories\ArticleRepository;
use App\Repositories\MsqArticleRepository;

use function DI\create;
use function DI\get;
use function DI\autowire;

// DI container configuration
return [
    ArticleRepository::class => create(MsqArticleRepository::class),
];
