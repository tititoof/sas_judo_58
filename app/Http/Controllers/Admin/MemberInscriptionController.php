<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\InscriptionsRepository;
use App\Http\Controllers\Controller;
use App\Builders\Inscriptions\Director;

class MemberInscriptionController extends Controller
{
    /**
     *
     */
    public function index()
    {
        $repository = new InscriptionsRepository;
        return response()->json($repository->getList());
    }

    /**
     * Load member inscription informations
     * @param Request $request
     */
    public function load(Request $request)
    {
        $director = new Director;
        return response()->json($director->check($request));
    }

    /**
     * Save member inscription informations
     * @param Request $request
     */
    public function save(Request $request)
    {
        $director = new Director;
        $answer     = $director->build($request);
        return response()->json($answer, $answer['code']);
    }
}
