<?php

namespace App\Http\Controllers;

use App\Models\Misa;
use App\Models\MisaUsers;
use App\Models\ListEvent;
use Illuminate\Http\Request;
use Auth;
use DB;

class ReservasiMisaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('list_events')
                ->where('jenis_event', 'like', 'Mi%')
                ->get();
                
        $misa = DB::table('misas')
        ->join('misa_users', 'misas.id', '=', 'misa_users.misas_id')
        ->where('users_id', Auth::user()->id)->get();

        return view('reservasimisa.index',compact("data", "misa"));
    }

    // public function PesanTiket(Request $request)
    // {
    //     $id = $request->id;
    //     $list = DB::table('list_events')->where('id', $id)->get();

    //     return view('reservasimisa.InputForm',compact("list"));
    // }

    public function PesanTiket(Request $request)
    {
        $id=$request->get("id");
        $list=ListEvent::find($id);
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('reservasimisa.PesanTiket',compact('list'))->render()),200);
    }

    public function store(Request $request)
    {
        $data = new Misa();
        $data->jadwal = $request->get('jadwal');
        $data->lokasi = $request->get('lokasi');
        $data->kuota = $request->get('kuota');
        $data->romo = $request->get('romo');
        $data->save();

        $misas = new MisaUsers();
        $misas->users_id = Auth::user()->id;
        $misas->misas_id = $data->id;
        $misas->kode_booking = "abc";
        $misas->jumlah_tiket = $request->get('jumlah_tiket');
        $misas->status = "Aktif";
        $misas->save();

        return redirect()->route('reservasimisa.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Tiket Misa Berhasil Dipesan');
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
     * Display the specified resource.
     *
     * @param  \App\Models\Misa  $misa
     * @return \Illuminate\Http\Response
     */
    public function show(Misa $misa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Misa  $misa
     * @return \Illuminate\Http\Response
     */
    public function edit(Misa $misa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Misa  $misa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Misa $misa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Misa  $misa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Misa $misa)
    {
        //
    }
}
