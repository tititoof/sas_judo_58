<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    /**
     * Mass assignement
     */
    protected $fillable = ['season_id', 'member_id', 'minor_go_alone', 'major_take_off', 'complementary_insurance'];

    /**
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function season() {
        return $this->belongsTo('App\Models\Season');
    }

    /**
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function member() {
        return $this->belongsTo('App\Models\Member');
    }
}
