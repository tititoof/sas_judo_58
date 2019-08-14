<?php

namespace App\Factories\Articles;

use App\Models\Category;

/**
 *
 */
abstract class AbstractFactory
{
    abstract public function build(Category $menu, Array $options);

}
