<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewMessage extends Model
{
    use HasFactory;
    public $guarded=['id'];
    public $timestamps=false;

    public function chatMessage(){
        return $this->belongsTo(ChatMessage::class);
    }
}
