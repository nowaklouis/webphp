<?php

namespace App\Table;

use App\PaginatedQuery;
use App\Model\Post;
use ParseError;

class PostTable extends Table
{
    protected $table = "post";
    protected $class = Post::class;


    public function findPaginated()
    {
        $paginatedQuery = new PaginatedQuery(
            "SELECT * FROM post ORDER BY created_at DESC",
            "SELECT COUNT(id) FROM post",
            $this->pdo
        );
        $posts = $paginatedQuery->getItems(Post::class);
        return [$posts, $paginatedQuery];
    }

    public function findPaginatedForCategory(int $categoryID)
    {
        $paginatedQuery = new PaginatedQuery(
            "SELECT p.* 
                FROM post p 
                JOIN post_category pc ON pc.post_id = p.id 
                WHERE pc.category_id = {$categoryID} 
                ORDER BY created_at DESC",
            "SELECT COUNT(category_id) 
                FROM post_category 
                WHERE category_id = {$categoryID}"
        );

        $posts = $paginatedQuery->getItems(Post::class);
        return [$posts, $paginatedQuery];
    }

    public function delete(int $id)
    {
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = ?");
        $query->execute([$id]);
    }

    public function update(Post $post): void
    {
        $query = $this->pdo->prepare("UPDATE {$this->table} SET name= :name, slug= :slug, content= :content, created_at= :created_at WHERE id = :id");
        $query->execute([
            'id' => $post->getId(),
            'name' => $post->getName(),
            'slug' => $post->getSlug(),
            'content' => $post->getContent(),
            'created_at' => $post->getCreatedAt()->format('Y-m-d h:i:s'),
        ]);
    }

    public function create(Post $post): void
    {
        $query = $this->pdo->prepare("INSERT INTO {$this->table} SET name= :name, slug= :slug, content= :content, created_at= :created_at");
        $query->execute([
            'name' => $post->getName(),
            'slug' => $post->getSlug(),
            'content' => $post->getContent(),
            'created_at' => $post->getCreatedAt()->format('Y-m-d h:i:s'),
        ]);
    }
}
