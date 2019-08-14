<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pictures()
    {
        return $this->belongsToMany('App\Models\Picture', 'albums_pictures', 'album_id', 'picture_id');
    }

    public function articles()
    {
        return $this->belongsToMany('App\Models\Article', 'albums_articles', 'album_id', 'article_id');
    }
}
