<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
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
     * @var string[]
     */
    //ls champs rmplissable qu on peut accepter
    protected $fillable = [
        'nom',
        'email',
        'password',
        'pseudo',
        'prenom',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    //les champs confidentiel 

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role(){
        return $this->hasOne('app\Models\Role');
    }

    public function tweets(){
        return $this->hasMany('app\Models\Tweet');
    }

    public function comments(){
        return $this->hasMany('app\Models\Comment');//un user peu poster un commentaires ou plusieur commentaires
    }
}
