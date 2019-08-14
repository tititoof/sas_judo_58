<?php

namespace App\Http\Controllers\Admin;

use App\Models\Season;
use App\Repositories\SeasonsRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class SeasonController
 * @package App\Http\Controllers\Admin
 */
class SeasonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seasons = Season::All();
        return response()->json(['seasons' => $seasons]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $repository = new SeasonsRepository;
        return response()->json($repository->save($request));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * @param Season $season
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Season $season)
    {
        return response()->json(['success' => true, 'object' => $season]);
    }

    /**
     * @param Request $request
     * @param Season $season
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Season $season)
    {
        $repository = new SeasonsRepository;
        return response()->json($repository->update($request, $season));
    }

    /**
     * @param Season $season
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Season $season)
    {
        $repository = new SeasonsRepository;
        return response()->json($repository->delete($season));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getList()
    {
        $repository = new SeasonsRepository;
        return response()->json($repository->getList());
    }
}
