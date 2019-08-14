<?php

namespace App\Factories\Articles;

use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Helpers\Answer;

/**
 *
 */
class ArticlesFactory extends AbstractFactory
{

    /**
     * @param Category $menu
     * @param Array $options
     */
    public function build(Category $menu, Array $options)
    {
        
        return Answer::success(200, $this->getArticles($menu, $options));
    }
    
    /**
     * @param Category $menu
     * @param Array $options
     */
    private function getArticles(Category $menu, $options)
    {
        $nbPerPage       = 10;
        $collect         = $menu->articles;
        $collect         = $collect->reverse();
        $page            = $options['page'] ?? 1;
        $articlesPerPage = $collect->forPage($page, 10);
        $nbArticles      = $collect->count();
        
        $articlesPerPage = $articlesPerPage->map(function($item, $key) {
            return [
                'name'      => $item->name,
                'content'   => $item->content,
                'albums'    => $item->albums,
                'images'    => $item->albums()->pictures,
            ];
        });
        $allArticles     = $articlesPerPage->all();
        return [ 
            'articles'      => array_reverse($allArticles), 
            'nbArticles'    => $nbArticles, 
            'nbPerPage'     => $nbPerPage, 
            'name'          => $menu->name 
        ];
    }

}
