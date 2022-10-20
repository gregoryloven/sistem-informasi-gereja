<?php

namespace App\Http\Controllers;

use App\Models\Perkawinan;
use Illuminate\Http\Request;
use Auth;

class PendaftaranPerkawinanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $perkawinan = Perkawinan::where('user_id', Auth::user()->id)->get();

        // return view('pendaftaranperkawinan.index',compact("perkawinan"));
        return view('pendaftaranperkawinan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pendaftaranperkawinan.InputForm');
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
     * @param  \App\Models\Perkawinan  $perkawinan
     * @return \Illuminate\Http\Response
     */
    public function show(Perkawinan $perkawinan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Perkawinan  $perkawinan
     * @return \Illuminate\Http\Response
     */
    public function edit(Perkawinan $perkawinan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Perkawinan  $perkawinan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Perkawinan $perkawinan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Perkawinan  $perkawinan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Perkawinan $perkawinan)
    {
        //
    }
}
