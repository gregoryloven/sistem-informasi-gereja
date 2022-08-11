<?php

namespace App\Http\Controllers;

use App\Models\ListEvent;
use Illuminate\Http\Request;

class ListEventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=ListEvent::all();
        return view('listevent.index',compact("data"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new ListEvent();
        $data->nama_event = $request->get('nama_event');
        $data->jenis_event = $request->get('jenis_event');
        $data->jadwal = $request->get('jadwal');
        $data->lokasi = $request->get('lokasi');
        $data->romo = $request->get('romo');
        
        $data->save();

        return redirect()->route('listevents.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Event Berhasil ditambahkan');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ListEvent  $listEvent
     * @return \Illuminate\Http\Response
     */
    public function show(ListEvent $listEvent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ListEvent  $listEvent
     * @return \Illuminate\Http\Response
     */
    public function edit(ListEvent $listEvent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ListEvent  $listEvent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ListEvent $listEvent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ListEvent  $listEvent
     * @return \Illuminate\Http\Response
     */
    public function destroy(ListEvent $listEvent)
    {
        //
    }
}
