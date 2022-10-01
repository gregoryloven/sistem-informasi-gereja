<?php

namespace App\Http\Controllers;

use App\Models\Misa;
use App\Models\MisaUsers;
use App\Models\ListEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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
                
        $misa = DB::table('list_events')
        ->join('misa_users', 'list_events.id', '=', 'misa_users.list_events_id')
        ->where('users_id', Auth::user()->id)
        ->get(['list_events.*', 'misa_users.users_id as usersID', 'misa_users.list_events_id as listeventsID', 
        'misa_users.kode_booking', 'misa_users.jumlah_tiket', 'misa_users.status', 'misa_users.created_at', 
        'misa_users.updated_at']);

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
        // return $request->all();
        $kode = Str::random(6);

        $listevent = ListEvent::where('id', $request->get('id'))->first();
        if($listevent->kuota > $request->get('jumlah_tiket')){
            $cek_maks_pesan = MisaUsers::where('users_id', Auth::user()->id)->where('status', 'Aktif')->get();
            $maks_pesan = 0;
            foreach($cek_maks_pesan as $cek){
                $maks_pesan += $cek->jumlah_tiket;
            }

            if($maks_pesan >= 5){
                return redirect()->back()->with('error', 'Maaf, Anda sudah melebihi batas maksimal pesan tiket. Maksimal 5 Tiket');
            } else {
                $listevent->kuota -= $request->get('jumlah_tiket');
                $listevent->save();
    
                $misas = new MisaUsers();
                $misas->users_id = Auth::user()->id;
                $misas->list_events_id = $listevent->id;
                $misas->kode_booking = strtoupper($kode);
                $misas->jumlah_tiket = $request->get('jumlah_tiket');
                $misas->status = "Aktif";
                $misas->save();
            }
            
        } else {
            return redirect()->back()->with('error', 'Kuota tidak mencukupi');
        }
        
        return redirect()->route('reservasimisa.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Tiket Misa Berhasil Dipesan');
    }

    public function Pembatalan(Request $request)
    {
        // return $request->all();
        $tobats = MisaUsers::where('kode_booking', $request->kode_booking)->update([
            'status' => 'Dibatalkan',
        ]);

        $listevent = ListEvent::where('id', $request->listeventsID)->first();
        $listevent->kuota += $request->jumlah_tiket;
        $listevent->save();

        return redirect()->route('reservasimisa.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Tiket Tobat Telah Dibatalkan');
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
    public function destroy(Misa $misa, Request $request)
    {
        return $request->all();
    }
}
