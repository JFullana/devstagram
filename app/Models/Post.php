<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id'
    ];

    //un post solo tiene un usuario (1:1)
    //con las relaciones en los modelos (clases) no tienes que aplicar "where" de sql, laravel lo hace automáticamente
    public function user()
    {
        return $this->belongsTo(User::class)->select(['name', 'username']);
    }

    //un post tendrá múltiples comentarios
    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function checkLike(User $user)
    {
        //Accedemos a la relación del método like y comprueba si existe el id (contains)
        return $this->likes->contains('user_id', $user->id);
    }


    
}
