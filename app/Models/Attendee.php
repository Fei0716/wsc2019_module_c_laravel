<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'attendee_id', 'id');

    }
}
