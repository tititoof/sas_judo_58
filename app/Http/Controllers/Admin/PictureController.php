<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PictureFormRequest;
use App\Models\Picture;
use App\Repositories\PictureRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

/**
 * Class PictureController
 * @package App\Http\Controllers\Admin
 */
class PictureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param PictureFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PictureFormRequest $request)
    {
        $repo = new PictureRepository;
        return response()->json($repo->save($request));
    }

    /**
     * @param $image
     * @param bool $resize
     * @return mixed
     */
    public function show($image, $resize = true)
    {
        $height = (true !== $resize) ? 898 : 150;
        return $this->getImage($image, $height);
    }

    public function miniShow($image)
    {
        $height = 100;
        return $this->getImage($image, $height);
    }

    private function getImage($image, $height)
    {
        // Do so other checks here if you wish
        if (is_numeric($image)) {
            $picture = Picture::findOrFail($image);
            $image = $picture->filename;
        } else {
            if (!File::exists(storage_path("app/images/{$image}"))) {
                abort(404);
            }
        }
        $img = File::get(storage_path("app/images/{$image}"));
        $returnImage = Image::make($img)->resize(null, $height, function ($constraint) {
            $constraint->aspectRatio();
        });
        return $returnImage->response();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
