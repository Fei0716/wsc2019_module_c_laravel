<?php

namespace App\Http\Controllers;

use App\Models\Event;

class ReportController extends Controller
{
    public function index(Event $event)
    {
        $data = [];
        foreach ($event->channels as $channel) {
            foreach ($channel->sessions as $session) {
                $temp = [
                    'title' => $session->title,
                    'capacity' => $session->room->capacity,
                ];
                if ($session->type == 'talk') {
                    $temp['attendee'] = $event->registrations->count();
                } else {
                    //need extra ticket
                    $temp['attendee'] = $session->sessionRegistrations->count();
                }
                $data[] = $temp;
            }
        }

        return view('reports.index')->with(['event' => $event, 'data' => $data]);
    }
}
