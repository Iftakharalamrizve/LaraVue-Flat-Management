<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MillHistory extends Model
{
    
    protected $fillable = [
        'user_id', 'date','mill_status'
    ];
}
