<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KomuniPertama;
use App\Models\User;
use App\Models\Paroki;

class KomuniPertamaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = KomuniPertama::all();
        $users = User::all();
        $romo = User::where('role','romo')->get();
        $paroki = Paroki::all();
        return view('komunipertama.index',compact("data","users","romo","paroki"));
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
     * @param  \App\Models\KomuniPertama  $komuniPertama
     * @return \Illuminate\Http\Response
     */
    public function show(KomuniPertama $komuniPertama)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KomuniPertama  $komuniPertama
     * @return \Illuminate\Http\Response
     */
    public function edit(KomuniPertama $komuniPertama)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KomuniPertama  $komuniPertama
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KomuniPertama $komuniPertama)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KomuniPertama  $komuniPertama
     * @return \Illuminate\Http\Response
     */
    public function destroy(KomuniPertama $komuniPertama)
    {
        //
    }
}
