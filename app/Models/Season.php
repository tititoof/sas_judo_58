<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'start_at', 'end_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function courses()
    {
        return $this->hasMany('App\Models\Course');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relastions\HasMany
     */
    public function results()
    {
      return $this->hasMany('App\Models\Result');
    }
}
