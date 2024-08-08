<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventTicket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Event $event, Request $request)
    {
        $special_validity = $request->special_validity;
        $special_validated = [];
        $json_valid = null;
        if ($special_validity != '') {
            if ($special_validity == 'amount') {
                $special_validated = ['amount' => 'required|min:1'];
                $json_valid = json_encode([
                    'type' => 'amount',
                    'amount' => $request->amount,
                ]);
            } elseif ($special_validity == 'date') {
                $special_validated = ['valid_until' => 'required|date_format:Y-m-d'];
                $json_valid = json_encode([
                    'type' => 'date',
                    'date' => $request->valid_until,
                ]);
            }
        }
        $validated = $request->validate(array_merge([
            'name' => 'required',
            'cost' => 'required',
        ], $special_validated));
        $ticket = new EventTicket();
        $ticket->event_id = $event->id;
        $ticket->name = $validated['name'];
        $ticket->cost = $validated['cost'];
        $ticket->special_validity = $json_valid;
        $ticket->save();

        return redirect()->route('event.show', $event)->with('success', 'Ticket successfully created');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Event $event)
    {
        return view('tickets.create', compact('event'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
