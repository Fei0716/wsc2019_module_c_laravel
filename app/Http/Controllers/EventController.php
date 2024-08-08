<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $organizer = Organizer::find(Auth::user()->id);
        return view('events.index')->with(['organizer' => $organizer]);
    }

    public function show(Event $event, Request $request)
    {
        return view('events.detail')->with(['event' => $event]);
    }

    public function create(Event $event, Request $request)
    {
        return view('events.create')->with(['event' => $event]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:events,slug,null,null,organizer_id,' . Auth::user()->id . '|regex: /^[a-z0-9-]*$/',
            'date' => 'required|date_format:Y-m-d',
        ], [
            'slug.unique' => 'Slug is already used',
            'slug.regex' => "Slug must not be empty and only contain a-z, 0-9 and '-'",
        ]);

        $event = Event::insert([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'date' => $validated['date'],
            'organizer_id' => Auth::user()->id,
        ]);
        return redirect()->route('event.show', $event)->with(['event' => $event]);
    }

    public function edit(Event $event, Request $request)
    {
        return view('events.edit')->with(['event' => $event]);
    }

    public function update(Event $event, Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:events,slug,' . $event->id . ',id,organizer_id,' . Auth::user()->id . '|regex: /^[a-z0-9-]*$/',
            'date' => 'required|date_format:Y-m-d',
        ], [
            'slug.unique' => 'Slug is already used',
            'slug.regex' => "Slug must not be empty and only contain a-z, 0-9 and '-'",
        ]);

        $event->name = $validated['name'];
        $event->slug = $validated['slug'];
        $event->date = $validated['date'];
        $event->save();

        return redirect()->route('event.show', $event)->with(['event' => $event, 'success' => 'Event successfully updated']);
    }
}
