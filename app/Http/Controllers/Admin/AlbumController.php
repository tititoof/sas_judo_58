<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AlbumFormRequest;
use App\Models\Album;
use App\Models\Picture;
use App\Repositories\AlbumRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $albums = Album::All();
        return response()->json(['albums' => $albums]);
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
     * @param AlbumFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AlbumFormRequest $request)
    {
        $repository = new AlbumRepository;
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
     * @param Album $album
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Album $album)
    {
        $pictures    = $album->pictures;
        $albumRepo   = new AlbumRepository;
        $allPictures = $albumRepo->getOtherPictures($pictures);
        return response()->json(['success' => true, 'object' => $album, 'pictures' => $pictures, 'all_pictures' => $allPictures]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Album $album)
    {
        $repository = new AlbumRepository;
        return response()->json($repository->update($request, $album));
    }

    /**
     * @param Album $album
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Album $album)
    {
        $albumRepo = new AlbumRepository;
        return response()->json($albumRepo->delete($album));
    }

    public function syncPicture(Picture $picture, Album $album)
    {
        $album->pictures()->toggle($picture);
        $albumRepo = new AlbumRepository;
        $allPictures = $albumRepo->getOtherPictures($album->pictures);
        return response()->json(['success' => true, 'object' => $album, 'pictures' => $album->pictures, 'all_pictures' => $allPictures ]);
    }
}
