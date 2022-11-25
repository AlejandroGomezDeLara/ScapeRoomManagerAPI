<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameReservationHour extends Model
{
    use HasFactory;
    public $table='game_reservation_hours';

    public function openReservation(){
        return $this->hasMany(OpenReservation::class);
    }

    public function reservation(){
        return $this->hasMany(Reservation::class);
    }
}
