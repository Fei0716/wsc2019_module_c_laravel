<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Organizer extends Authenticatable
{
    public $timestamps = false;

    use HasFactory;

    protected $fillable = [
        'password_hash',
    ];

    protected $hidden = [
        'password_hash',
    ];

    //    has events
    public function events()
    {
        return $this->hasMany(Event::class, 'organizer_id', 'id');
    }
}
