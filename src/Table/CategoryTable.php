<?php

namespace App\Table;

use App\Model\Category;

class CategoryTable extends Table
{
    protected $table = "category";
    protected $class = Category::class;
}
