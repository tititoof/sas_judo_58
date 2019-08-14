<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ResultsRepository;
use App\Http\Requests\ResultFormRequest;
use App\Models\Season;
use App\Models\Result;
use App\Traits\ListTrait;

/**
 * Resultat Controller
 */
class ResultatController extends Controller
{
    /**
     * 
     * 
     */
    use ListTrait;
    
    const MAPLIST = 'mapList';
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $repo = new ResultsRepository;
        return response()->json([ 'results' => $repo->getAdminAll() ]);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $seasons  = Season::All();
        $list     = $seasons->map([$this, self::MAPLIST]);
        return response()->json(['seasons' => $list]);
    }

    /**
     * @param ResultFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ResultFormRequest $request)
    {
        $repo = new ResultsRepository;
        return response()->json($repo->save($request));
    }

    /**
     * @param $image
     * @param bool $resize
     * @return mixed
     */
    public function show($image, $resize = true)
    {
    
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit(Result $result)
    {
        $seasons  = Season::All();
        $list     = $seasons->map([$this, self::MAPLIST]);
        return response()->json([
            'seasons'         => $list,
            'result'          => $result,
            'seasonSelected'  => ['label' => $result->season->name, 'value' => $result->season->id],
            'informations'    => json_decode($result->informations),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ResultFormRequest $request
     * @param  Result  $result
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(ResultFormRequest $request, Result $result)
    {
        $repo = new ResultsRepository;
        return response()->json($repo->update($request, $result));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Result  $result
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Result $result)
    {
        $repo = new ResultsRepository;
        return response()->json($repo->delete($result));
    }
}
