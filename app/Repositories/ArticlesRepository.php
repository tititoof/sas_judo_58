<?php
/**
 * Created by PhpStorm.
 * User: tititoof
 * Date: 02/01/17
 * Time: 12:06
 */

namespace App\Repositories;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\ArticleFormRequest;
use App\Models\Article;
use App\Helpers\Answer;

class ArticlesRepository
{
    /**
     * @param ArticleFormRequest $request
     * @return array
     */
    public function save(ArticleFormRequest $request)
    {
        $article = new Article;
        return $this->update($request, $article);
    }

    /**
     * @param ArticleFormRequest $request
     * @param Article $article
     * @return array
     */
    public function update(ArticleFormRequest $request, Article $article)
    {
        try {
            $article->name          = $request->input('name');
            $article->content       = $request->input('content');
            $article->user_id       = $request->input('user_id');
            $article->save();
            $article->categories()->sync($request->input('categories'));
            $article->albums()->sync($request->input('albums'));
            return Answer::success(200, ['article_id' => $article->id]);
        } catch (\Exception $exception) {
            return Answer::error($exception);
        }
    }

    /**
     * @param Article $article
     * @return array
     */
    public function delete(Article $article)
    {
        try {
            $article->categories()->detach();
            $article->albums()->detach();
            $article->delete();
            return Answer::success(200);
        } catch (\Exception $exception) {
            return Answer::error($exception);
        }
    }

    /**
     * @param $page
     * @return array
     */
    public function getArticles($page)
    {
        try {
            $articles    = DB::table('articles')->orderBy('id', 'desc')->get();
            $pagedData   = collect($articles);
            $perPage     = 5;
            $currentPage = $page - 1;
            if ($pagedData->count() > $perPage) {
                $pagedData   = array_slice($articles, $currentPage * $perPage, $perPage);
            }
            return Answer::success(200, $pagedData);
        } catch (\Exception $exception) {
            return Answer::error($exception);
        }
    }

    public function getAdminArticles()
    {
        try {
            $articles = Article::all()->reverse();
            return $articles->map(function($article) {
                $menus = $article->categories->map(function($menu) {
                    return $menu->name;
                });
                return [
                    'id'    => $article->id,
                    'name'  => $article->name,
                    'menus' => $menus,
                ];
            });
        } catch (\Exception $exception) {
            return Answer::error($exception);
        }
    }
}
