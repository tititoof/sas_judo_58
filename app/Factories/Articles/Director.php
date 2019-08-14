<?php

namespace App\Factories\Articles;

use App\Models\Category;
use App\Factories\Articles\ArticlesFactory;
use App\Factories\Articles\NewsFactory;
use App\Helpers\Answer;

/**
 *
 */
class Director
{
    const LABEL     = 'label';
    const NAME      = 'name';

    /**
     * @var Array $listFactories
     */
    private static $listFactories = [
        [ self::LABEL => 'News',        self::NAME  => 'NewsFactory'],
        [ self::LABEL => 'Articles',    self::NAME  => 'ArticlesFactory'],
        [ self::LABEL => 'Résultats',   self::NAME  => 'ResultatsFactory'],
    ];

    /**
     * @param Menu $menu
     */
    public static function build(Category $menu, $page)
    {
        $strType = 'App\\Factories\\Articles\\'.$menu->type;
        $style = new \ReflectionClass($strType);
        if ($style->hasMethod('build')) {
            $object = $style->newInstance();
            $method = $style->getMethod('build');
            return $method->invoke($object, $menu, ['page' => $page]);
        }
        return Answer::error(
            new \InvalidArgumentException('Impossible de trouver le factory', 404),
            []
        );
    }

    /**
     * @return Array
     */
    public static function getListFactories()
    {
        return self::$listFactories;
    }

}
