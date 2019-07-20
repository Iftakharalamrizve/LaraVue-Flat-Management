<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MillHistory extends Model
{
    
    protected $fillable = [
        'user_id', 'date','mill_status','mill_status2'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
