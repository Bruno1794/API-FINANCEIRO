<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    //
    protected $table = 'banks';
    protected $fillable = [
        'id',
        'name',
        'balance',
        'count',
        'type_count',
        'path_img',
        'user_id',
    ];
}
