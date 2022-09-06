<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranPetugas;
use App\Models\User;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use Auth;
use DB;

class PendaftaranPetugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $data = DB::table('list_events')
        ->join('petugas_liturgis', 'list_events.petugas_liturgi_id', '=', 'petugas_liturgis.id')
        ->where('list_events.jenis_event', 'Petugas Liturgi')
        ->get(['list_events.id','list_events.nama_event','list_events.jenis_event','list_events.tgl_buka_pendaftaran',
        'list_events.tgl_tutup_pendaftaran','list_events.jadwal_pelaksanaan','list_events.lokasi','petugas_liturgis.jenis_petugas as jenisPetugas',
        ]);

        $petugas = PendaftaranPetugas::where('user_id', Auth::user()->id)->get();
        $user = User::all();

        if(optional(Auth::user())->id){
            return view('pendaftaranpetugas.index',compact("data", "petugas", "user"));
        }else{
            return redirect('/login');
        }
    }

    public function OpenForm(Request $request)
    {
        $id = $request->id;

        $list = DB::table('list_events')
        ->join('petugas_liturgis', 'list_events.petugas_liturgi_id', '=', 'petugas_liturgis.id')
        ->where([['list_events.jenis_event', 'Petugas Liturgi'], ['list_events.id', $id]])
        ->get(['list_events.id','list_events.nama_event','list_events.jenis_event','list_events.tgl_buka_pendaftaran',
        'list_events.tgl_tutup_pendaftaran','list_events.jadwal_pelaksanaan','list_events.lokasi','petugas_liturgis.jenis_petugas as jenisPetugas'
        ]);

        $user = DB::table('users')
            ->join('lingkungans', 'users.lingkungan_id', '=', 'lingkungans.id')
            ->join('kbgs', 'users.kbg_id', '=', 'kbgs.id')
            ->where('users.id', Auth::user()->id)
            ->get();

        return view('pendaftaranpetugas.InputForm',compact("list", "user"));
    }

    public function InputForm(Request $request)
    {
        $data = new PendaftaranPetugas;
        $data->user_id =  Auth::user()->id;
        $data->nama_lengkap = $request->get("nama_lengkap");
        $data->jenis_petugas_liturgi = $request->get("jenis_petugas");
        $data->lingkungan = $request->get("lingkungan");
        $data->kbg = $request->get("kbg");
        $data->jadwal = $request->get("jadwal");
        $data->lokasi = $request->get("lokasi");
        $data->telepon = $request->get("telepon");
        $data->status = "Diproses";
        $data->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->event_id =  $data->id;
        $riwayat->jenis_event =  $request->get("jenis_event");
        $riwayat->status =  "Diproses";
        $riwayat->save();

        return redirect()->route('pendaftaranpetugas.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Petugas Liturgi Berhasil');
    }

    public function detail(Request $request)
    {
        $id=$request->get("id");
        $log=Riwayat::where([['event_id', '=', $id], ['jenis_event', '=', 'Petugas Liturgi']])
        ->get();
        
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('pendaftaranpetugas.detail', compact("log"))->render()),200);
    }

    public function Pembatalan(Request $request)
    {
        $data=PendaftaranPetugas::find($request->id);
        $data->status = "Dibatalkan";
        $data->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->event_id =  $data->id;
        $riwayat->jenis_event =  "Petugas Liturgi";
        $riwayat->status =  "Dibatalkan";
        $riwayat->alasan_pembatalan = $request->get("alasan_pembatalan");
        $riwayat->save();

        return redirect()->route('pendaftaranpetugas.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Petugas Liturgi Berhasil Dibatalkan');
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
     * @param  \App\Models\PendaftaranPetugas  $pendaftaranPetugas
     * @return \Illuminate\Http\Response
     */
    public function show(PendaftaranPetugas $pendaftaranPetugas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PendaftaranPetugas  $pendaftaranPetugas
     * @return \Illuminate\Http\Response
     */
    public function edit(PendaftaranPetugas $pendaftaranPetugas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PendaftaranPetugas  $pendaftaranPetugas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PendaftaranPetugas $pendaftaranPetugas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PendaftaranPetugas  $pendaftaranPetugas
     * @return \Illuminate\Http\Response
     */
    public function destroy(PendaftaranPetugas $pendaftaranPetugas)
    {
        //
    }
}
