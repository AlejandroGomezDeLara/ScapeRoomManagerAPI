<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenReservationUser extends Model
{
    use HasFactory;
    public $guarded=['id'];
    public $table="open_reservation_users";

}
