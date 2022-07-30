<?php

namespace App\Http\Controllers;

use App\Models\Baptis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Paroki;

class PendaftaranBaptisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Baptis::all();
        $users = User::all();
        $wali_baptis_ayah = User::where([['role', 'not like','%romo%'], ['jenis_kelamin', 'Pria']])->get();
        $wali_baptis_ibu = User::where([['role', 'not like','%romo%'], ['jenis_kelamin', 'Wanita']])->get();
        $romo = User::where('role','romo')->get();
        $paroki = Paroki::all();
        return view('pendaftaranbaptis.index',compact("data","users","wali_baptis_ayah","wali_baptis_ibu","romo","paroki"));
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

    public function InputForm(Request $request)
    {
        $data = new Baptis;
        $data->user_id = $request->get("nama_user");
        $data->wali_baptis_ayah = $request->get("wali_baptis_ayah");
        $data->wali_baptis_ibu = $request->get("wali_baptis_ibu");
        $data->paroki_id = $request->get("paroki_id");
        $data->jenis = $request->get("jenis");
        $data->jadwal = date('Y-m-d', strtotime(str_replace('/', '-',$request->input('jadwal'))));
        $data->status = "Diproses";
        $data->save();

        return redirect('/pendaftaranbaptis');
    }
}
