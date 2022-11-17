<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    public function category(){
        return $this->belongsTo(GameCategory::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function subcategory(){
        return $this->belongsTo(GameSubcategory::class);
    }

    public function openReservations(){
        return $this->hasMany(OpenReservation::class);
    }

}
