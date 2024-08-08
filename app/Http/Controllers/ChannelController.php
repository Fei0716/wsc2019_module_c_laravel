<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Event;
use Illuminate\Http\Request;

class ChannelController extends Controller
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
        return view('channels.create')->with('event', $event);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Event $event, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
        ]);
        $channel = new Channel();
        $channel->event_id = $event->id;
        $channel->name = $request->name;
        $channel->save();

        return redirect()->route('event.show', $event)->with('success', 'Channel successfully created');

    }

    /**
     * Display the specified resource.
     */
    public function show(Channel $channel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Channel $channel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Channel $channel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Channel $channel)
    {
        //
    }
}
