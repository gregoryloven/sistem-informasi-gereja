<?php

namespace App\Http\Controllers;

use App\Models\PendaftaranPelayananLainnya;
use App\Models\PendaftaranPetugas;
use App\Models\PetugasLiturgi;
use App\Models\User;
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
                ->where('jenis_event', 'like', 'Petugas%')
                ->get();
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
        $list = DB::table('list_events')->where('id', $id)->get();
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
        $data->petugas_liturgi_id = $request->get("petugas_liturgi_id");
        $data->lingkungan = $request->get("lingkungan");
        $data->kbg = $request->get("kbg");
        $data->jenis_petugas = $request->get("jenis_petugas");
        $data->jadwal = $request->get("jadwal");
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
