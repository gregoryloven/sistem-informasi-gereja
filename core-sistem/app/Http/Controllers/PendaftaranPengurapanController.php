<?php

namespace App\Http\Controllers;

use App\Models\PengurapanOrangSakit;
use App\Models\Riwayat;
use App\Models\ListEvent;
use Illuminate\Http\Request;
use Auth;
use DB;

class PendaftaranPengurapanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role != 'umat')
        {
            return back();
        }
        else
        {
            $data = PengurapanOrangSakit::where('user_id', Auth::user()->id)->get();
            if (Auth::user()->status !== "Tervalidasi") {
                $user = [];
            } else {
                $user = DB::table('users')
                ->join('lingkungans', 'users.lingkungan_id', '=', 'lingkungans.id')
                ->join('kbgs', 'users.kbg_id', '=', 'kbgs.id')
                ->where('users.id', Auth::user()->id)
                ->get();
            }

            if(optional(Auth::user())->id){
                return view('pendaftaranpengurapan.index',compact("data", "user"));
            }else{
                return redirect('/login');
            }
        }
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
        $data = new PengurapanOrangSakit;
        $data->user_id =  Auth::user()->id;
        $data->nama_lengkap = $request->get("nama_lengkap");
        $data->lingkungan = $request->get("lingkungan");
        $data->kbg = $request->get("kbg");
        $data->jadwal = $request->get("jadwal");
        $data->alamat = $request->get("alamat");
        $data->telepon = $request->get("telepon");
        $data->keterangan = $request->get("keterangan");
        $data->status = "Diproses";
        $data->save();

        $list =  new ListEvent();
        $list->nama_event = "Pengurapan";
        $list->jenis_event = "Pengurapan";
        $list->jadwal_pelaksanaan = $data->jadwal;
        $list->lokasi = $data->alamat;
        $list->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->list_event_id = $list->id;
        $riwayat->event_id =  $data->id;
        $riwayat->jenis_event =  "Pengurapan";
        $riwayat->status =  "Diproses";
        $riwayat->save();

        return redirect()->route('pendaftaranpengurapan.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Pengurapan Orang Sakit Berhasil');
        
    }

    public function detail(Request $request)
    {
        $id=$request->get("id");
        $log=Riwayat::where([['event_id', '=', $id], ['jenis_event', '=', 'Pengurapan']])
        ->get();
        
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('pendaftaranpengurapan.detail', compact("log"))->render()),200);
    }

    public function Pembatalan(Request $request)
    {
        $data=PengurapanOrangSakit::find($request->id);
        $data->status = "Dibatalkan";
        $data->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->event_id =  $data->id;
        $riwayat->jenis_event =  "Pengurapan";
        $riwayat->status =  "Dibatalkan";
        $riwayat->alasan_pembatalan = $request->get("alasan_pembatalan");
        $riwayat->save();

        return redirect()->route('pendaftaranpengurapan.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pengurapan Orang Sakit Berhasil Dibatalkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PengurapanOrangSakit  $pengurapanOrangSakit
     * @return \Illuminate\Http\Response
     */
    public function show(PengurapanOrangSakit $pengurapanOrangSakit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PengurapanOrangSakit  $pengurapanOrangSakit
     * @return \Illuminate\Http\Response
     */
    public function edit(PengurapanOrangSakit $pengurapanOrangSakit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PengurapanOrangSakit  $pengurapanOrangSakit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PengurapanOrangSakit $pengurapanOrangSakit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PengurapanOrangSakit  $pengurapanOrangSakit
     * @return \Illuminate\Http\Response
     */
    public function destroy(PengurapanOrangSakit $pengurapanOrangSakit)
    {
        //
    }
}
