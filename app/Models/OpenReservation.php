<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenReservation extends Model
{
    use HasFactory;
    public $guarded=['id'];

    public function users(){
        return $this->belongsToMany(User::class);
    }
    public function game(){
        return $this->belongsTo(Game::class);
    }
    public function gameCategory(){
        return $this->belongsTo(GameCategory::class);
    }
    public function gameSubcategory(){
        return $this->belongsTo(GameSubcategory::class);
    }
}
