<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['content','tags','image','_token'];

// definir la relation de cardinalité

    public function tweet(){
        return $this->belongsTo('app\Models\Tweet');//un a un belongTo / $this fait reference a la classe elle même
    }
    public function user(){
        return $this->belongsTo('app\Models\User');
    }
}
