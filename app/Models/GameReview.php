<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameReview extends Model
{
    use HasFactory;
    public $guarded=["id"];
    
    public function getImageAttribute($value){
        if($this->attributes['image'])
        return url('storage/'.$this->attributes['image']);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
