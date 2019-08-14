<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Judoevent extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'start_at', 'end_at'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'judo_events';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users() {
        return $this->belongsToMany('App\Models\User', 'judo_events_user', 'user_id', 'judo_event_id');
    }
}
