<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function rooms()
    {
        return $this->hasMany(Room::class, 'channel_id', 'id');
    }

    public function sessions()
    {
        return $this->hasManyThrough(Session::class, Room::class, 'channel_id', 'room_id');
    }
}
