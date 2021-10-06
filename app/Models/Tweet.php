<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;
    
    protected $fillable = ['content','image','tags','_token','user_id'];

    
    public function user(){
        return $this->belongsTo('app\Models\User');
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
