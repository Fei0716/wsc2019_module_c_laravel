<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventTicket extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function getAvailabilityAttribute()
    {
        $special_validity = $this->special_validity ? json_decode($this->special_validity, true) : null;
        if ($special_validity && $special_validity['type'] == 'amount') {
            if ($this->registrations->count() >= $special_validity['amount']) {
                return false;
            } else {
                return true;
            }
        } elseif ($special_validity && $special_validity['type'] == 'date') {
            if (date('Y-m-d') >= $special_validity['date']) {
                return false;
            } else {
                return true;
            }
        }
    }

    public function getDescriptionAttribute()
    {
        $description = null;
        $special_validity = json_decode($this->special_validity, true);
        if ($special_validity) {
            if ($this->availability && $special_validity['type'] == 'date') {
                $description = 'Available until ' . date('M d, Y', strtotime($special_validity['date']));
            } elseif (!$this->availability && ($special_validity['type'] == 'date' || $special_validity['type'] == 'amount')) {
                $description = 'Not Available';
            } elseif ($this->availability && $special_validity['type'] == 'amount') {
                $description = $special_validity['amount'] - $this->registrations->count() . ' tickets available';
            }
        }
        return $description;
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'ticket_id', 'id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }
}
