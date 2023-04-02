<?php

namespace App\Model;

class Category
{
    private $id;
    private $slug;
    private $name;

    public function getID(): ?int
    {
        return $this->id;
    }

    public function getSLUG(): ?string
    {
        return $this->slug;
    }

    public function getNAME(): ?string
    {
        return $this->name;
    }
}
