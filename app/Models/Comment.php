<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function quack(){
        return $this->belongsTo('app\models\Quack');
    }
    public function user(){
        return $this->belongsTo('app\models\user');
    }
}
