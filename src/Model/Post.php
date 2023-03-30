<?php

namespace App\Model;

use App\Helpers\Text;
use \DateTime;

class Post
{
    private int $id;
    private string $name;
    private string $content;
    private string $slug;
    private $created_at;
    private $categories;

    public function getName()
    {
        return $this->name;
    }

    public function getExcerpt()
    {
        if ($this->content === null) {
            return null;
        }
        return nl2br(htmlentities(Text::excerpt($this->content, 60)));
    }

    public function getCreatedAt(): DateTime
    {
        return new DateTime($this->created_at);
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getId()
    {
        return $this->id;
    }
}