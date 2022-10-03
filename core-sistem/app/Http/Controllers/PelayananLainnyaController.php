<?php

namespace App\Http\Controllers;

use App\Models\PelayananLainnya;
use App\Models\PendaftaranPelayananLainnya;
use App\Models\Riwayat;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use DB;

class PelayananLainnyaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pelayanan = PelayananLainnya::all();
        $data = PendaftaranPelayananLainnya::where('user_id', Auth::user()->id)->get();
        if (Auth::user()->status !== "Tervalidasi") {
            $user = [];
        } else {
            $user = DB::table('users')
            ->join('lingkungans', 'users.lingkungan_id', '=', 'lingkungans.id')
            ->join('kbgs', 'users.kbg_id', '=', 'kbgs.id')
            ->where('users.id', Auth::user()->id)
            ->get();
        }
        $riwayat = Riwayat::all();

        if(optional(Auth::user())->id){
            return view('pelayananlainnya.index',compact("pelayanan", "data", "user", "riwayat"));
        }else{
            return redirect('/login');
        }
    }

    public function InputForm(Request $request)
    {
        // return $request->all();
        $data = new PendaftaranPelayananLainnya;
        $data->user_id =  Auth::user()->id;
        $data->nama_lengkap = $request->get("nama_lengkap");
        $data->pelayanan_lainnya_id = $request->get("pelayanan_lainnya_id");
        $data->lingkungan = $request->get("lingkungan");
        $data->kbg = $request->get("kbg");
        $data->jadwal = $request->get("jadwal");
        $data->alamat = $request->get("alamat");
        $data->telepon = $request->get("telepon");
        $data->keterangan = $request->get("keterangan");
        $data->status = "Diproses";
        $data->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->list_event_id = $request->event_id;
        $riwayat->event_id =  $data->id;
        $riwayat->jenis_event =  "Pelayanan";
        $riwayat->status =  "Diproses";
        $riwayat->save();

        return redirect()->route('pelayananlainnya.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Pelayanan Berhasil');
        
    }

    public function detail(Request $request)
    {
        $id=$request->get("id");
        $log=Riwayat::where([['event_id', '=', $id], ['jenis_event', '=', 'Pelayanan']])
        ->get();
        
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('pelayananlainnya.detail', compact("log"))->render()),200);
    }

    public function Pembatalan(Request $request)
    {
        $data=PendaftaranPelayananLainnya::find($request->id);
        $data->status = "Dibatalkan";
        $data->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->event_id =  $data->id;
        $riwayat->jenis_event =  "Pelayanan";
        $riwayat->status =  "Dibatalkan";
        $riwayat->alasan_pembatalan = $request->get("alasan_pembatalan");
        $riwayat->save();

        return redirect()->route('pelayananlainnya.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Pelayanan Berhasil Dibatalkan');
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
     * @param  \App\Models\PelayananLainnya  $pelayananLainnya
     * @return \Illuminate\Http\Response
     */
    public function show(PelayananLainnya $pelayananLainnya)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PelayananLainnya  $pelayananLainnya
     * @return \Illuminate\Http\Response
     */
    public function edit(PelayananLainnya $pelayananLainnya)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PelayananLainnya  $pelayananLainnya
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PelayananLainnya $pelayananLainnya)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PelayananLainnya  $pelayananLainnya
     * @return \Illuminate\Http\Response
     */
    public function destroy(PelayananLainnya $pelayananLainnya)
    {
        //
    }


    // public function InputFormAll(Request $request)
    // {
    //     $idKepalaKeluarga = $request->get("idKepalaKeluarga");

    //     $keluarga = User::where('keluarga_id', $idKepalaKeluarga)
    //     ->get(); 

    //     //for ($x = 0; $x <= count($keluarga)-1; $x++) {
    //         // echo $keluarga[$x]->nama;
    //         $pendaftaran_pelayanan = new PendaftaranPelayananLainnya;
    //         $pendaftaran_pelayanan->pelayanan_lainnya_id = $request->get("pelayanan");
    //         $pendaftaran_pelayanan->nama_pemohon = $keluarga[$x]->nama_user;
    //         $pendaftaran_pelayanan->jadwal = $request->get("jadwal");
    //         $pendaftaran_pelayanan->alamat = $request->get("alamat");
    //         $pendaftaran_pelayanan->keterangan = $request->get("keterangan");
    //         $pendaftaran_pelayanan->status = "Pending";
    //         $pendaftaran_pelayanan->save();
    //       //}
    //       return $keluarga;
    //     return redirect('/pelayananlainnya');
    // }

    public function listFamily(){
        $data=User::all();
        echo json_encode( $data );
        return $data;
    }
}
