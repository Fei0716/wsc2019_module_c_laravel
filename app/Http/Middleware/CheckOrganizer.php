<?php

namespace App\Http\Middleware;

use App\Models\Event;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckOrganizer
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
//        return $next($request);
        $event_slug = explode('/', $request->getRequestUri())[2];
        $event = Event::where('slug', $event_slug)->first();
        if ($event->organizer_id != Auth::user()->id) {
            return redirect()->route('event.index')->withErrors(['error' => 'Unauthorized Access']);
        }
        return $next($request);
    }
}
