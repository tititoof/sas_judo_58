<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'articles_categories', 'article_id', 'category_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function albums()
    {
        return $this->belongsToMany('App\Models\Album', 'albums_articles', 'article_id', 'album_id');
    }
}
