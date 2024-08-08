<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function eventTicket()
    {
        return $this->belongsTo(EventTicket::class, 'ticket_id', 'id');
    }

    public function sessionRegistrations()
    {
        return $this->hasMany(SessionRegistration::class, 'registration_id', 'id');
    }
}
