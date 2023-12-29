<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    //Forma de crear una relación entre la tabla usuarios y posts (un usuario puede tener muchos posts 1:N)
    //MUY IMPORTANTE seguir las convenciones en los nombres de la funciones para que laravel identifique como actuar. 
    public function posts()
    {
        //relación de one to many
        return $this->hasMany(Post::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    //Almacena los seguidores de un usuario
    public function followers()
    {
        //cuando salimos de las convenciones hay que pasar la tabla y las foreign keys como argumentos
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    //Almacena los que seguimos
    public function followings()
    {
        //cuando salimos de las convenciones hay que pasar la tabla y las foreign keys como argumentos
        return $this->belongsToMany(User::class, 'followers','follower_id' , 'user_id');
    }
    
    //comprobar si un usuario sigue a otro
    public function siguiendo(User $user)
    {
        //si accedemos a un método de la propia clase el método va sin paréntesis
        return $this->followers->contains($user->id);
    }

    
}
