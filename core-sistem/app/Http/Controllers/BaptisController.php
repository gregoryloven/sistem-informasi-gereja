<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Baptis;
use App\Models\User;
use App\Models\Paroki;

class BaptisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Baptis::all();
        $users = User::all();
        $paroki=Paroki::all();
        return view('baptis.index',compact("data","users","paroki"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user=User::all();
        $par=Paroki::all();
        return view("baptis.create", compact('user', 'par'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = new Baptis();
        $data->users_id = $request->get('users_id');
        $data->wali_baptis_ayah = $request->get('wali_baptis_ayah');
        $data->wali_baptis_ibu = $request->get('wali_baptis_ibu');
        $data->id_romo = $request->get('id_romo');
        $data->parokis_id = $request->get('parokis_id');
        $data->jenis = $request->get('jenis');
        $data->tanggal_pembaptisan = $request->get('tanggal_pembaptisan');
        $data->status = $request->get('status');
        
        $data->save();

        return redirect()->route('baptiss.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Data KBG Berhasil ditambahkan');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Baptis  $baptis
     * @return \Illuminate\Http\Response
     */
    public function show(Baptis $baptis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Baptis  $baptis
     * @return \Illuminate\Http\Response
     */
    public function edit(Baptis $baptis)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Baptis  $baptis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Baptis $baptis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Baptis  $baptis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Baptis $baptis)
    {
        //
    }
}
