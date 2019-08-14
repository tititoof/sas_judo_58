<?php

namespace App\Repositories;

use App\Models\AgeCategory;
use App\Helpers\Answer;
use Illuminate\Http\Request;

/**
 * Age Category Data Manage
 */
class AgeCategoryRepository
{

    /**
    * Save new entity
    * @param Request $request
    * @return array
    */
    public function save(Request $request)
    {
        return $this->update($request, new AgeCategory);
    }

    /**
    * Update entity
    * @param Request $request
    * @param AgeCategory $ageCategory
    */
    public function update(Request $request, AgeCategory $ageCategory)
    {
        try {
            $ageCategory->name  = $request->input('name');
            $ageCategory->years = $request->input('years');
            $ageCategory->save();
        } catch (\Exception $exception) {
            return Answer::error($exception, $ageCategory);
        }
        return Answer::success(200, $ageCategory);
    }

    /**
    * Delete entity
    * @return array
    */
    public function delete(AgeCategory $ageCategory)
    {
        try {
            $ageCategory->delete();
        } catch (\Exception $exception) {
            return Answer::error($exception);
        }
        return Answer::success(200);
    }
    
    public function getAll()
    {
        return AgeCategory::All();
    }
}
