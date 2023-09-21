<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = 'events';
        $events = Event::latest()->get();
        return view('admin.events', compact('page', 'events'));
    }
    public function create()
    {
        $page = 'create event';
        return view('admin.create-event', \compact('page'));
    }
    public function store(Request $request)
    {
        Event::create($request->all());
        session()->flash('success', 'Event created successfully');
        return redirect()->route('events.index');
    }
    public function edit($id)
    {
        $page = 'update event';
        $event = Event::find($id);
        return view('admin.update_event', compact('page', 'event'));
    }
    public function update(Request $request, $id)
    {
        $event = Event::find($id);
        $event->fill($request->all());
        $event->save();
        session()->flash('success', 'Event updated successfully');
        return redirect()->route('events.index');
    }
    public function destroy($id)
    {
        $event = Event::find($id);
        $event->delete();
        session()->flash('success', 'Event deleted successfully');
        return back();
    }
}
