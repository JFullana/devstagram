<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        //Al asociarlo en la clase posts con la relación hasMany no es necesario ponerlo aquí
        //'post_id'
    ];
}
