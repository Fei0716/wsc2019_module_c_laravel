<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Event $event)
    {
        return view('sessions.create')->with('event', $event);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Event $event, Request $request)
    {
        $validated = $request->validate([
            'type' => 'required',
            'title' => 'required',
            'speaker' => 'required',
            'start' => 'required|date_format:Y-m-d H:i',
            'end' => 'required|date_format:Y-m-d H:i|after:start',
            'description' => 'required',
        ]);

        //check whether the room already used by other session during that time
        $isBooked = Session::where('room_id', $request->room)
            ->where('start', '<=', $validated['end'])
            ->where('end', '>=', $validated['start'])
            ->first();
        if ($isBooked) {
            return back()->withErrors(['start' => 'Room already booked during this time'])->withInput();
        }
        $session = new Session();
        $session->room_id = $request->room;
        $session->title = $validated['title'];
        $session->description = $validated['description'];
        $session->speaker = $validated['speaker'];
        $session->start = $validated['start'];
        $session->end = $validated['end'];
        $session->type = $validated['type'];
        $session->cost = $validated['type'] == 'talk' ? null : $request->cost;

        $session->save();

        return redirect()->route('event.show', $event)->with('success', 'Session successfully created');

    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event, Session $session, string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event, Session $session)
    {
        return view('sessions.edit')->with(['event' => $event, 'session' => $session]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Event $event, Session $session, Request $request)
    {
        $validated = $request->validate([
            'type' => 'required',
            'title' => 'required',
            'speaker' => 'required',
            'start' => 'required|date_format:Y-m-d H:i',
            'end' => 'required|date_format:Y-m-d H:i|after:start',
            'description' => 'required',
        ]);

        //check whether the room already used by other session during that time
        $isBooked = Session::where('room_id', $request->room)
            ->whereNot('id', $session->id)
            ->where('start', '<=', $validated['end'])
            ->where('end', '>=', $validated['start'])
            ->first();

        if ($isBooked) {
            return back()->withErrors(['start' => 'Room already booked during this time'])->withInput();
        }
        $session->room_id = $request->room;
        $session->title = $validated['title'];
        $session->description = $validated['description'];
        $session->speaker = $validated['speaker'];
        $session->start = $validated['start'];
        $session->end = $validated['end'];
        $session->type = $validated['type'];
        $session->cost = $validated['type'] == 'talk' ? null : $request->cost;
        $session->save();

        return redirect()->route('event.show', $event)->with('success', 'Session successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
