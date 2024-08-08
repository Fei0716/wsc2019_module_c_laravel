<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventDetailResource;
use App\Http\Resources\EventResource;
use App\Http\Resources\UserRegistrationResource;
use App\Models\Attendee;
use App\Models\Event;
use App\Models\EventTicket;
use App\Models\Organizer;
use App\Models\Registration;
use App\Models\SessionRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $events = Event::where('date', '>', date('Y-m-d'))->orderBy('date', 'asc')->get();

        return response()->json(['events' => EventResource::collection($events)], 200);
    }

    public function show($organizer_slug, $event_slug, Request $request)
    {
        $organizer = Organizer::where('slug', $organizer_slug)->first();
        $event = Event::where([
            'slug' => $event_slug,
        ])->first();
        //If organizer does not exist
        if (!$organizer) {
            return response()->json(['message' => 'Organizer not found'], 404);
        }
        //If event does not exist or was not created by the organizer
        if (!$event || $event->organizer_id != $organizer->id) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        return response()->json(new EventDetailResource($event), 200);
    }

    public function register($organizer_slug, $event_slug, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ticket_id' => 'required',
        ]);
        if ($validator->fails()) {
            $errorMessage = $validator->errors()->first();
            $response = [
                'status' => false,
                'message' => $errorMessage,
            ];
            return response()->json($response, 401);
        }
        $organizer = Organizer::where('slug', $organizer_slug)->first();

        $event = Event::where([
            'slug' => $event_slug,
        ])->first();
        //If organizer does not exist
        if (!$organizer) {
            return response()->json(['message' => 'Organizer not found'], 404);
        }
        //If event does not exist or was not created by the organizer
        if (!$event || $event->organizer_id != $organizer->id) {
            return response()->json(['message' => 'Event not found'], 404);
        }
        $user = Attendee::where([
            'login_token' => $request->token,
        ])->first();
        if (!$user) {
            return response()->json(['message' => 'Invalid token'], 403);
        }
        $isRegistered = $event->registrations()->where([
            'attendee_id' => $user->id,
            'ticket_id' => $request->ticket_id,
        ])->first();
        //if already registered for this event
        if ($isRegistered) {
            return response()->json(['message' => 'User already registered'], 401);
        }
        $ticket = EventTicket::where('id', $request->ticket_id)->first();
        if (!$ticket || $ticket->availability) {
            return response()->json(['message' => 'Ticket is no longer available'], 401);
        }

        $registration = new Registration();
        $registration->attendee_id = $user->id;
        $registration->ticket_id = $ticket->id;
        $registration->registration_time = Carbon::now();
        $registration->save();
        //register for sessions
        if ($request->session_ids) {
            foreach ($request->session_ids as $session_id) {
                $sessionRegistration = new SessionRegistration();
                $sessionRegistration->registration_id = $registration->id;
                $sessionRegistration->session_id = $session_id;
                $sessionRegistration->save();
            }
        }
        return response()->json(['message' => 'Registration successful'], 200);
    }

    public function getRegistrations(Request $request)
    {
        $token = $request->token;
        $user = Attendee::where([
            'login_token' => $request->token,
        ])->first();
        if (!$user) {
            return response()->json(['message' => 'Invalid token'], 403);
        }
        return response()->json(['registrations' => UserRegistrationResource::collection($user->registrations)]);
    }
}
