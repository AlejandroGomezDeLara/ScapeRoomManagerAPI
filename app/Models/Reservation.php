<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;
    public $guarded=['id'];

    public function game(){
        return $this->belongsTo(Game::class);
    }

    public function gameReservationHour(){
        return $this->belongsTo(GameReservationHour::class);
    }

    public function gamePrice(){
        return $this->belongsTo(GamePrice::class);
    }
}
