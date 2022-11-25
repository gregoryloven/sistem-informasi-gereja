<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\KomuniPertama;
use App\Models\ListEvent;
use App\Models\Riwayat;
use DB;
use Auth;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class PendaftaranKomuniController extends Controller
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
            $data = ListEvent::where([['jenis_event', 'like', 'Ko%'], ['status', 'Aktif']])
            ->orderBy('jadwal_pelaksanaan', 'ASC')
            ->get();
            $komuni = KomuniPertama::where('user_id', Auth::user()->id)->get();
            $user = User::all();
            return view('pendaftarankomuni.index',compact("data", "komuni", "user"));
        }
    }

    public function OpenForm(Request $request)
    {
        // $this->authorize('lingkungan-permission');
        if(Auth::user()->status !== "Tervalidasi"){
            return redirect()->back()->with('error', 'Anda Belum Terdaftar Sebagai Umat Pada Lingkungan & Kbg Yang ada. Silahkan Daftar Halaman Pendaftaran Umat');
        } else {
            $id = $request->id;
        
            $list = DB::table('list_events')->where('id', $id)->get();
            $user = DB::table('users')
                ->join('lingkungans', 'users.lingkungan_id', '=', 'lingkungans.id')
                ->join('kbgs', 'users.kbg_id', '=', 'kbgs.id')
                ->where('users.id', Auth::user()->id)
                ->get();
    
            return view('pendaftarankomuni.InputForm',compact("list", "user"));
        }
    }

    public function InputForm(Request $request)
    {
        $data = new KomuniPertama();
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
        
        $data->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->list_event_id = $request->event_id;
        $riwayat->jenis_event =  $request->get("jenis_event");
        $riwayat->event_id =  $data->id;
        $riwayat->status =  "Diproses";
        $riwayat->save();

        return redirect()->route('pendaftarankomuni.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Komuni Pertama Berhasil');
    }

    public function detail(Request $request)
    {
        $id=$request->get("id");
        $log=Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
        ->where([['event_id', '=', $id], ['riwayats.jenis_event', 'like', 'Komuni Pertama']])
        ->get(['riwayats.*', 'list_events.keterangan_kursus as Ket']);
        
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('pendaftarankomuni.detail', compact("log"))->render()),200);
    }

    public function Pembatalan(Request $request)
    {
        $data=KomuniPertama::find($request->id);
        $data->status = "Dibatalkan";
        $data->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->event_id =  $data->id;
        $riwayat->jenis_event =  $request->get("jenis_event");
        $riwayat->status =  "Dibatalkan";
        $riwayat->alasan_pembatalan = $request->get("alasan_pembatalan");
        $riwayat->save();

        return redirect()->route('pendaftarankomuni.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Komuni Pertama Berhasil Dibatalkan');
    }

    public function sertifikat_komunipertama(Request $request)
    {
        // return $request->all();
        $komunipertama = KomuniPertama::where('user_id', $request->id)->first();
        // return $komunipertama;

        $pdf = PDF::loadView('pendaftarankomuni.sertifikat', compact('komunipertama'));
        $pdf->setPaper('a4', 'landscape');
        return $pdf->stream('Sertifikat_KomuniPertama.pdf');
        
        
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
     * @param  \App\Models\PendaftaranKomuni  $pendaftaranKomuni
     * @return \Illuminate\Http\Response
     */
    public function show(PendaftaranKomuni $pendaftaranKomuni)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PendaftaranKomuni  $pendaftaranKomuni
     * @return \Illuminate\Http\Response
     */
    public function edit(PendaftaranKomuni $pendaftaranKomuni)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PendaftaranKomuni  $pendaftaranKomuni
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PendaftaranKomuni $pendaftaranKomuni)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PendaftaranKomuni  $pendaftaranKomuni
     * @return \Illuminate\Http\Response
     */
    public function destroy(PendaftaranKomuni $pendaftaranKomuni)
    {
        //
    }
}
