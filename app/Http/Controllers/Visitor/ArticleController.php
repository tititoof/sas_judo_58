<?php

namespace App\Http\Controllers\Visitor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ArticlesRepository;
use App\Repositories\PictureRepository;

class ArticleController extends Controller
{
    public function index($page)
    {
        $repository = new ArticlesRepository;
        return response()->json($repository->getArticles($page));
    }

    public function carousel()
    {
        $repository = new PictureRepository;
        return response()->json($repository->carousel());
    }
}
