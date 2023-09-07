<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowRequest extends Model
{
    protected $fillable = [
        'receiver_id','sender_id'
    ];
    use HasFactory;
}
