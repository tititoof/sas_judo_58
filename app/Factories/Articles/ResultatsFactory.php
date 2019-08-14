<?php

namespace App\Factories\Articles;

use App\Models\Category;
use App\Models\Result;
use App\Repositories\ResultsRepository;
use App\Repositories\AgeCategoryRepository;
use App\Helpers\Answer;

/**
 *
 */
class ResultatsFactory extends AbstractFactory
{

    /**
     * @param Category $menu
     * @param Array $options
     */
    public function build(Category $menu, Array $options)
    {
        $resultRepo      = new ResultsRepository;
        $ageCategories   = new AgeCategoryRepository;
        $nbPerPage       = 10;
        return Answer::success(200, array_merge(
            $resultRepo->getAll($options['page'] ?? 1), 
            [ 'ageCategories' => $ageCategories->getAll(), ] 
        ));
    }

}