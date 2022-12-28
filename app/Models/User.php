<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded=['id'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public function getAvatarAttribute($value){
        if($this->attributes['avatar'])
        return (str_contains($this->attributes['avatar'],'https') || str_contains($this->attributes['avatar'],'http')) ? $this->attributes['avatar'] :url('storage/'.$this->attributes['avatar']);
    }

    public function getBannerImgAttribute($value){
        if($this->attributes['banner_img'])
        return (str_contains($this->attributes['banner_img'],'https') || str_contains($this->attributes['banner_img'],'http')) ? $this->attributes['banner_img'] :url('storage/'.$this->attributes['banner_img']);
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}