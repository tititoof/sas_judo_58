<?php

namespace App\Http\Controllers\Visitor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CategoriesRepository;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use App\Models\Category;
use App\Factories\Articles\Director;


class MenuController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index()
    {
        $repository = new CategoriesRepository;
        return response()->json($repository->getMenu());
    }

    /**
     *
     */
    public function image($name, $resize = true)
    {
        if (!File::exists(storage_path("app/public/{$name}"))) {
            return ['success' => false, 'errors' => 'File not found'];
        }
        $img = File::get(storage_path("app/public/{$name}"));
        $height = (true !== $resize) ? 898 : 150;
        $returnImage = Image::make($img)->resize($height, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        return $returnImage->response();
    }

    /**
     * @return JsonResponse
     */
    public function show(Category $category, $page)
    {
        $director = new Director;
        $articles = $director->build($category, $page);
        return response()->json($articles);
    }
    
    /**
     * 
     */
    public function background()
    {
        return $this->getFile('background.jpg')->response();
    }
    
    public function logo()
    {
        return $this->getFile('logo_judo.png')->response();
    }
    
    private function getFile($file)
    {
        if (!File::exists(storage_path("app/public/".$file))) {
            return ['success' => false, 'errors' => 'File not found'];
        }
        $img         = File::get(storage_path("app/public/".$file));
        return Image::make($img);
    }
}
