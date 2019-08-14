<?php
/**
 * Created by PhpStorm.
 * User: tititoof
 * Date: 22/01/17
 * Time: 14:57
 */

namespace App\Repositories;

use App\Models\Album;
use App\Models\Picture;
use App\Helpers\Answer;
use Illuminate\Http\Request;

/**
 * Class AlbumRepository
 * @package App\Repositories
 */
class AlbumRepository
{
    /**
     * @param Request $request
     * @return array
     */
    public function save(Request $request)
    {
        return $this->update($request, new Album);
    }

    /**
     * @param Request $request
     * @param Album $album
     * @return array
     */
    public function update(Request $request, Album $album)
    {
        try {
            $album->name    = $request->input('name');
            $album->user_id = $request->input('user_id');
            $album->save();
            $pictures = $album->pictures()->get()->map(function($picture) {
                return $picture->id;
            });
            if (count($pictures) > 0)  {
                $album->pictures()->sync($pictures->merge($request->input('pictures')) );
            } else {
                $album->pictures()->sync($request->input('pictures') );
            }
        } catch (\Exception $exception) {
            return Answer::error($exception);
        }
        return Answer::success(200, ['album_id' => $album->id, 'album_name' => $album->name]);
    }

    /**
     * @param $pictures
     * @return static
     */
    public function getOtherPictures($pictures)
    {
        $allPictures    = Picture::All();
        return $allPictures->diff($pictures);
    }

    /**
     * @param Album $album
     * @return array
     */
    public function delete(Album $album)
    {
        try {
            $album->articles()->detach();
            $album->pictures()->detach();
            $album->delete();
            return Answer::success(200);
        } catch (\Exception $exception) {
            return Answer::error($exception);
        }
    }
}
