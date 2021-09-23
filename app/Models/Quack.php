<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quack extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo('app\models\User','user_id');
    }
    public function comments(){
        return $this->hashMany('app\models\Comment');
    }
}
