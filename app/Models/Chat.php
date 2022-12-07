<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    public $guarded=['id'];

    public function users(){
        return $this->belongsToMany(User::class,'chat_users');
    }

    public function openReservation(){
        return $this->belongsTo(OpenReservation::class);
    }
}
