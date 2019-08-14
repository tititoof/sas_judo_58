<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    /**
     * Mass assignement
     */
    protected $fillable = ['firstname', 'lastname', 'sexe', 'birthday',
      'address', 'postal_code', 'city', 'phone', 'red_list', 'mobile', 'email'];

}
