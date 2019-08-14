<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Manage
 */
class AgeCategory extends Model
{
  /**
   * The attributes that are mass assignable
   * @var array
   */
  protected $fillable = ['name', 'years'];

  /**
   * The table associated with the model.
   *
   * @var string
   */
  protected $table = 'age_categories';

  /**
   * @return Illuminate\Database\Eloquent\Relations\HasMany
   */
  public function results()
  {
    return $this->hasMany('App\Models\Result');
  }
}
