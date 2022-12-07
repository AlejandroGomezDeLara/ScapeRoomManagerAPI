<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameImage extends Model
{
    use HasFactory;
    public $guarded = ['id'];
    public $timestamps = false;

    public function getImageAttribute($value)
    {
        if (!str_contains($this->attributes['image'], 'https://') && !str_contains($this->attributes['image'], 'http://'))
            return url('storage/' . $this->attributes['image']);
        else return $this->attributes['image'];
    }
}
