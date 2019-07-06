<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Events;
use App\Http\Resources\Event;

class EventController extends Controller
{
    public function __construct() {
        \Cloudinary::config(array(
            "cloud_name" => env("CLOUDINARY_NAME"),
            "api_key" => 863943961898362,
            "api_secret" => env("CLOUDINARY_API_SECRET")
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function allEvents()
    {
        // get events
        $events = Events::all();
        // return collection of events as a resource
        return Event::collection($events);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createEvent(Request $request)
    {
        $event = Events::create($request->all());
        $event->event_poster = \Cloudinary\Uploader::upload($request->file["tmp_name"]);
        // $event = Input::all();
        // $event->category_id = $request->category_id;
        // $event->event_name = $request->event_name;
        // $event->event_description = $request->event_description;
        // $event->event_location = $request->event_location;
        // $event->event_date = $request->event_date;
        // $event->event_host = $request->event_host;
        // $event->event_time = $request->event_time;
        // $event->event_artists = $request->event_id;
        // $event->event_poster = $request->event_poster;
        $event->save();
        return response()->json($event,201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateEvent($id, Request $request)
    {
        $event = Events::where('event_id',$id)->update([$request->all()]);
        $event->save();
        return response()->json($event);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showEvent($id)
    {
        // get single Event
        $event = Events::find($id);
        // return the single event
        return response()->json($event);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyEvent($id)
    {
        $event = Events::where('event_id',$id)->get();
        $event->each->delete();
        return response()->json('Event Removed Successfully!');
    }
}
