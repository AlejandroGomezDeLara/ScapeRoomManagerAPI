<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GameReview extends Model
{
    use HasFactory;
    public $guarded = ["id"];

    public function getImageAttribute($value)
    {
        if ($this->attributes["image"]) {
            try {
                $image = Storage::disk('local')->get($this->attributes["image"]);
                return "data:image/jpeg;base64," . base64_encode($image);
            } catch (\Throwable $th) {
                return $this->attributes['image'];
            }
        } else return $this->attributes['image'];
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
