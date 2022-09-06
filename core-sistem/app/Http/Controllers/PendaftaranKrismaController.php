<?php

namespace App\Http\Controllers;

use App\Models\Krisma;
use App\Models\User;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use DB;
use Auth;

class PendaftaranKrismaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('list_events')
                ->where('jenis_event', 'like', 'Kr%')
                ->get();
        $krisma = Krisma::where('user_id', Auth::user()->id)->get();
        $user = User::all();
        return view('pendaftarankrisma.index',compact("data", "krisma", "user"));
    }

    public function OpenForm(Request $request)
    {
        $this->authorize('lingkungan-permission');
        $id = $request->id;
        
        $list = DB::table('list_events')->where('id', $id)->get();
        $user = DB::table('users')
            ->join('lingkungans', 'users.lingkungan_id', '=', 'lingkungans.id')
            ->join('kbgs', 'users.kbg_id', '=', 'kbgs.id')
            ->where('users.id', Auth::user()->id)
            ->get();

        return view('pendaftarankrisma.InputForm',compact("list", "user"));
    }

    public function InputFormSetempat(Request $request)
    {
        $data = new Krisma();
        $data->user_id = Auth::user()->id;
        $data->nama_lengkap = $request->get("nama_lengkap");
        $data->tempat_lahir = $request->get("tempat_lahir");
        $data->tanggal_lahir = $request->get("tanggal_lahir");
        $data->orangtua_ayah = $request->get("orangtua_ayah");
        $data->orangtua_ibu = $request->get("orangtua_ibu");
        $data->lingkungan = $request->get("lingkungan");
        $data->kbg = $request->get("kbg");
        $data->telepon = $request->get("telepon");
        $data->jadwal = $request->get("jadwal");
        $data->lokasi = $request->get("lokasi");
        $data->romo = $request->get("romo");
        $data->status = "Diproses";

        $file=$request->file('surat_baptis');
        $imgFolder = 'file_sertifikat/surat_baptis';
        $extension = $request->file('surat_baptis')->extension();
        $imgFile=time()."_".$request->get('nama').".".$extension;
        $file->move($imgFolder,$imgFile);
        $data->surat_baptis=$imgFile;

        $file2=$request->file('sertifikat_komuni');
        $imgFolder2 = 'file_sertifikat/sertifikat_komuni';
        $extension2 = $request->file('sertifikat_komuni')->extension();
        $imgFile2=time()."_".$request->get('nama').".".$extension;
        $file2->move($imgFolder2,$imgFile2);
        $data->sertifikat_komuni=$imgFile2;
        
        $data->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->jenis_event =  "Krisma";
        $riwayat->event_id =  $data->id;
        $riwayat->status =  "Diproses";
        $riwayat->save();

        return redirect()->route('pendaftarankrisma.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Krisma Berhasil');
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
     * @param  \App\Models\PendaftaranKrisma  $pendaftaranKrisma
     * @return \Illuminate\Http\Response
     */
    public function show(PendaftaranKrisma $pendaftaranKrisma)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PendaftaranKrisma  $pendaftaranKrisma
     * @return \Illuminate\Http\Response
     */
    public function edit(PendaftaranKrisma $pendaftaranKrisma)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PendaftaranKrisma  $pendaftaranKrisma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PendaftaranKrisma $pendaftaranKrisma)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PendaftaranKrisma  $pendaftaranKrisma
     * @return \Illuminate\Http\Response
     */
    public function destroy(PendaftaranKrisma $pendaftaranKrisma)
    {
        //
    }
}
