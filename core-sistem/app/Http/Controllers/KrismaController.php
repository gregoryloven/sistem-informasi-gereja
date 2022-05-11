<?php

namespace App\Http\Controllers;

use App\Models\Krisma;
use App\Models\User;
use App\Models\Paroki;
use Illuminate\Http\Request;

class KrismaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Krisma::all();
        $user=User::all();
        $par=Paroki::all();
        return view('krisma.index',compact("data","user","par"));
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
     * @param  \App\Models\Krisma  $krisma
     * @return \Illuminate\Http\Response
     */
    public function show(Krisma $krisma)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Krisma  $krisma
     * @return \Illuminate\Http\Response
     */
    public function edit(Krisma $krisma)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Krisma  $krisma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Krisma $krisma)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Krisma  $krisma
     * @return \Illuminate\Http\Response
     */
    public function destroy(Krisma $krisma)
    {
        //
    }
}
