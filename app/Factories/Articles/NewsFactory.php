<?php

namespace App\Factories\Articles;

use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Article;
use App\Helpers\Answer;

/**
 *
 */
class NewsFactory extends AbstractFactory
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
        $nbPerPage       = 5;
        $collect         = DB::table('articles')
                                ->join('articles_categories', 'articles_categories.article_id', '=', 'articles.id')
                                ->join('categories', 'categories.id', '=', 'articles_categories.category_id')
                                ->leftJoin('albums_articles', 'albums_articles.article_id', '=', 'articles.id')
                                ->leftJoin('albums', 'albums_articles.album_id', '=', 'albums.id')
                                ->select('articles.*')
                                ->where('categories.id', '=', $menu->id)
                                ->orderBy('articles_categories.id', 'desc')
                                ->get();
        $page            = $options['page'] ?? 1;
        $articlesPerPage = $collect->forPage($page, $nbPerPage);
        $nbArticles      = $collect->count();
        $articlesPerPage = $articlesPerPage->map(function($item, $key) {
            $article     = Article::find($item->id);
            return [
                'name'      => $item->name,
                'content'   => $item->content,
                'albums'    => $article->albums,
                'images'    => $this->getPictures($article->albums),
            ];
        });
        $allArticles     = $articlesPerPage->all();
        return [ 
            'articles'      => $allArticles,
            'nbArticles'    => $nbArticles, 
            'nbPerPage'     => $nbPerPage, 
            'name'          => $menu->name 
        ];
    }
    
    private function getPictures($albums)
    {
        $pictures = [];
        foreach ($albums as $album) {
            if ( is_array($album->pictures) && (count($album->pictures) > 0) ) {
                $pictures = array_merge($pictures, $album->pictures);
            }
        }
        return $pictures;
    }
}
