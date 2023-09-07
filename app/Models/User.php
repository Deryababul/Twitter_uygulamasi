<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // public function followers()
    // {
    //     return $this->belongsToMany(User::class, 'followers', 'following_id', 'follower_id');
    // }

  

    public function followRequests()
    {
        return $this->hasMany(FollowRequest::class, 'receiver_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function tweets(){
        return $this->hasMany(tweet::class);

    }

    public function followers() //takipçileri
    {
        return $this->hasMany(Follower::class, 'following_id', 'id');
    }

    public function followings() //takip ettikleri
    {
        return $this->hasMany(Follower::class, 'follower_id', 'id');
    }
}
