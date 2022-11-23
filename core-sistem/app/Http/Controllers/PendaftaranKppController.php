<?php

namespace App\Http\Controllers;

use App\Models\Kpp;
use App\Models\ListEvent;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use DB;
use Auth;

class PendaftaranKppController extends Controller
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
            $list = ListEvent::where([['jenis_event', 'like', 'Kursus%'], ['status', 'Aktif']])->get();
            $data = Kpp::where('user_id', Auth::user()->id)->get();
    
            return view('pendaftarankpp.index',compact("list", "data"));
        }
    }

    public function OpenForm(Request $request)
    {
        $id = $request->id;
        $list = DB::table('list_events')->where('id', $id)->get();

        return view('pendaftarankpp.InputForm',compact("list"));
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
        $data = new Kpp();
        $data->user_id = Auth::user()->id;
        //Calon Suami
        $data->nama_lengkap_calon_suami = $request->get("nama_lengkap_calon_suami");
        $data->tempat_lahir_calon_suami = $request->get("tempat_lahir_calon_suami");
        $data->tanggal_lahir_calon_suami = $request->get("tanggal_lahir_calon_suami");
        $data->nama_ayah_calon_suami = $request->get("nama_ayah_calon_suami");
        $data->nama_ibu_calon_suami = $request->get("nama_ibu_calon_suami");
        $data->alamat_calon_suami = $request->get("alamat_calon_suami");
        $data->telepon_calon_suami = $request->get("telepon_calon_suami");

        //Calon Istri
        $data->nama_lengkap_calon_istri = $request->get("nama_lengkap_calon_istri");
        $data->tempat_lahir_calon_istri = $request->get("tempat_lahir_calon_istri");
        $data->tanggal_lahir_calon_istri = $request->get("tanggal_lahir_calon_istri");
        $data->nama_ayah_calon_istri = $request->get("nama_ayah_calon_istri");
        $data->nama_ibu_calon_istri = $request->get("nama_ibu_calon_istri");
        $data->alamat_calon_istri = $request->get("alamat_calon_istri");
        $data->telepon_calon_istri = $request->get("telepon_calon_istri");

        $data->keterangan_kursus = $request->get("keterangan_kursus");
        // $data->lokasi = $request->get("lokasi");
        $data->lokasi = "Gereja A";
        $data->status = "Diproses";

        //ktp
        $file=$request->file('ktp_calon_suami');
        $imgFolder = 'file_kpp/ktp';
        $extension = $request->file('ktp_calon_suami')->extension();
        $imgFile=time()."_".$request->get('nama').".".$extension;
        $file->move($imgFolder,$imgFile);
        $data->ktp_calon_suami=$imgFile;

        $file2=$request->file('ktp_calon_istri');
        $imgFolder2 = 'file_kpp/ktp';
        $extension2 = $request->file('ktp_calon_istri')->extension();
        $imgFile2=time()."_".$request->get('nama').".".$extension2;
        $file2->move($imgFolder2,$imgFile2);
        $data->ktp_calon_istri=$imgFile2;

        //surat pengantar lingkungan
        $file3=$request->file('suratpengantar_lingkungan_calon_suami');
        if(isset($file3))
        {
            $imgFolder3 = 'file_kpp/suratpengantar_lingkungan';
            $extension3 = $request->file('suratpengantar_lingkungan_calon_suami')->extension();
            $imgfile3=time()."_".$request->get('nama').".".$extension3;
            $file3->move($imgFolder3,$imgfile3);
            $data->suratpengantar_lingkungan_calon_suami=$imgfile3;
        }

        $file4=$request->file('suratpengantar_lingkungan_calon_istri');
        if(isset($file4))
        {
            $imgFolder4 = 'file_kpp/suratpengantar_lingkungan';
            $extension4 = $request->file('suratpengantar_lingkungan_calon_istri')->extension();
            $imgfile4=time()."_".$request->get('nama').".".$extension4;
            $file4->move($imgFolder4,$imgfile4);
            $data->suratpengantar_lingkungan_calon_istri=$imgfile4;
        }

        //surat pengantar paroki
        $file5=$request->file('suratpengantar_paroki_calon_suami');
        if(isset($file5))
        {
            $imgFolder5 = 'file_kpp/suratpengantar_paroki';
            $extension5 = $request->file('suratpengantar_paroki_calon_suami')->extension();
            $imgFile5=time()."_".$request->get('nama').".".$extension5;
            $file5->move($imgFolder5,$imgFile5);
            $data->suratpengantar_paroki_calon_suami=$imgFile5;
        }

        $file6=$request->file('suratpengantar_paroki_calon_istri');
        if(isset($file6))
        {
            $imgFolder6 = 'file_kpp/suratpengantar_paroki';
            $extension6 = $request->file('suratpengantar_paroki_calon_istri')->extension();
            $imgFile6=time()."_".$request->get('nama').".".$extension6;
            $file6->move($imgFolder6,$imgFile6);
            $data->suratpengantar_paroki_calon_istri=$imgFile6;
        }

        $data->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->list_event_id = $request->list_event_id;
        $riwayat->jenis_event =  $request->jenis_event;
        $riwayat->event_id =  $data->id;
        $riwayat->status =  "Diproses";
        $riwayat->save();

        return redirect()->route('pendaftarankpp.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Kursus Persiapan Perkawinan Berhasil');
    }

    public function detail(Request $request)
    {
        $id=$request->get("id");
        $log = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
        ->where([['event_id', '=', $id], ['riwayats.jenis_event', 'like', 'Kursus%']])
        ->get('riwayats.*');
        
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('pendaftarankpp.detail', compact("log"))->render()),200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kpp  $kpp
     * @return \Illuminate\Http\Response
     */
    public function show(Kpp $kpp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kpp  $kpp
     * @return \Illuminate\Http\Response
     */
    public function edit(Kpp $kpp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kpp  $kpp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kpp $kpp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kpp  $kpp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $kpp=Kpp::find($request->id);
        $kpp->delete();

        $riwayat = Riwayat::where([['event_id', $request->id],['jenis_event', 'like', 'Kursus%']])->first();
        $riwayat->delete();

        return redirect()->route('pendaftarankpp.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Kursus Persiapan Perkawinan Berhasil Dibatalkan');
    }
}
