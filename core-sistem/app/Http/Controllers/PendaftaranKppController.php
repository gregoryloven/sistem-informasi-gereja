<?php

namespace App\Http\Controllers;

use App\Models\Kpp;
use App\Models\ListEvent;
use Illuminate\Http\Request;

class PendaftaranKppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = ListEvent::where([['jenis_event', 'like', 'Kursus%'], ['status', 'Aktif']])
        ->orderBy('jadwal_pelaksanaan', 'ASC')
        ->get();
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kpp  $kpp
     * @return \Illuminate\Http\Response
     */
    public function show(Kpp $kpp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kpp  $kpp
     * @return \Illuminate\Http\Response
     */
    public function edit(Kpp $kpp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kpp  $kpp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kpp $kpp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kpp  $kpp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kpp $kpp)
    {
        //
    }
}
