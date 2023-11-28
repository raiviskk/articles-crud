<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Collections\ArticleCollections;
use App\Models\Article;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class MsqArticleRepository implements ArticleRepository
{


    private Connection $database;

    public function __construct()
    {

        $connectionParams = [
            'dbname' => $_ENV['DB_NAME'],
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD'],
            'host' => $_ENV['DB_HOST'],
            'driver' => $_ENV['DB_DRIVER'],
        ];
        $this->database = DriverManager::getConnection($connectionParams);
    }

    public function getById(int $id): ?Article
    {
        $data = $this->database->createQueryBuilder()
            ->select('*')
            ->from('articles')
            ->where('id = :id')
            ->setParameter('id', $id)
            ->fetchAssociative();

        if (empty($data)) {
            return null;
        }

        return $this->buildModel($data);

    }

    public function getAll(): ArticleCollections
    {
        $articles = $this->database->createQueryBuilder()
            ->select('*')
            ->from('articles')
            ->fetchAllAssociative();

        $articlesCollection = new ArticleCollections();
        foreach ($articles as $data) {
            $articlesCollection->add(
                $this->buildModel($data)
            );
        }
        return $articlesCollection;

    }

    public function save(Article $article): void
    {

        $builder = $this->database->createQueryBuilder();
        if ($article->getId()) {
            $builder->update('articles')
                ->update('articles')
                ->set('title', ':title')
                ->set('description', ':description')
                ->set('updated_at', ':updated_at')
                ->where('id = :id')
                ->setParameters([
                    'id' => $article->getId(),
                    'title' => $article->getTitle(),
                    'description' => $article->getDescription(),
                    'updated_at' => $article->getUpdatedAt()
                ])->executeQuery();
            return;
        }
        $builder->insert('articles')
            ->insert('articles')
            ->values([
                    'title' => ':title',
                    'description' => ':description',
                    'picture' => ':picture',
                    'created_at' => ':created_at'
                ]
            )->setParameters([
                'title' => $article->getTitle(),
                'description' => $article->getDescription(),
                'picture' => $article->getPicture(),
                'created_at' => $article->getCreatedAt()
            ])->executeQuery();
    }

    public function delete(Article $article): void
    {
        $this->database->createQueryBuilder()
            ->delete('articles')
            ->where('id = :id')
            ->setParameter('id', $article->getId())
            ->executeQuery();
    }

    private function buildModel(array $data): Article
    {
        return new Article(
            $data['title'],
            $data['description'],
            $data['picture'],
            $data['created_at'],
            $data['id'],
            $data['updated_at']
        );
    }
}