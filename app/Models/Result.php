<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Result extends Model
{
  /**
   * The attributes that are mass assignable
   * @var array
   */
  protected $fillable = ['season_id', 'name', 'locality', 'contest_at', 'informations'];

  /**
   * @return \Illuminate\Database\Eloquent\Relations\belongsTo
   */
  public function season()
  {
    return $this->belongsTo('App\Models\Season');
  }
}
