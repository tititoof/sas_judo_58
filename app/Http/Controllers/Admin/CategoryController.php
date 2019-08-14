<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoriesFormRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\CategoriesRepository;
use App\Factories\Articles\Director;

/**
 * Class CategoryController
 * @package App\Http\Controllers\Admin
 */
class CategoryController extends Controller
{
    /**
     * Get all categories
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = Category::All();
        return response()->json([ 'categories' => $categories ]);
    }

    /**
     * Get factories
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        return response()->json([ 'factories' => Director::getListFactories() ]);
    }

    /**
     * @param CategoriesFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CategoriesFormRequest $request)
    {
        $categoryRepo = new CategoriesRepository;
        return response()->json($categoryRepo->save($request));
    }

    /**
     *
     */
    public function show()
    {

    }

    /**
     * @param Request $request
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request, Category $category)
    {
        return response()->json([ 'success' => true, 'object' => $category, 'factories' => Director::getListFactories() ]);
    }

    /**
     * @param CategoriesFormRequest $request
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CategoriesFormRequest $request, Category $category)
    {
        $categoryRepo = new CategoriesRepository;
        return response()->json($categoryRepo->update($request, $category));
    }

    /**
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Category $category)
    {
        $categoryRepo = new CategoriesRepository;
        return response()->json($categoryRepo->destroy($category));
    }
}
