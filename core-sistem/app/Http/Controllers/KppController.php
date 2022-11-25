<?php

namespace App\Http\Controllers;

use App\Models\Kpp;
use App\Models\ListEvent;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use DB;
use Auth;

class KppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role != 'admin')
        {
            return back();
        }
        else
        {
            $list = ListEvent::where([['jenis_event', 'like', 'Kursus%'], ['status', 'Aktif']])->get();
            $data = Kpp::where('user_id', Auth::user()->id)->get();

            // $data = Kpp::join('riwayats', 'kpps.id', '=', 'riwayats.event_id')
            // ->where([['riwayats.status', 'Disetujui Paroki'], ['riwayats.jenis_event', 'like', 'Kursus%']])
            // ->orwhere([['riwayats.status', 'Ditolak'], ['riwayats.jenis_event', 'like', 'Kursus%']])
            // ->orderBy('kpps.updated_at', 'DESC')
            // ->get(['kpps.*', 'riwayats.id as riwayatID', 'riwayats.status as statusRiwayat', 
            // 'riwayats.created_at', 'riwayats.updated_at', 'riwayats.alasan_penolakan']);

            $data = Kpp::where('status', 'Disetujui Paroki')
            ->orderBy('updated_at', 'DESC')
            ->get();
    
            return view('kpp.index',compact("list", "data"));
        }
    }

    public function OpenForm(Request $request)
    {
        $id = $request->id;
        $list = DB::table('list_events')->where('id', $id)->get();

        return view('kpp.InputForm',compact("list"));
    }

    public function RiwayatKpp(Request $request)
    {
        $id = $request->id;
        $data = Kpp::where('id', $id)->get();

        return view('kpp.RiwayatKpp',compact("data"));
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
        $kpp = Kpp::get(["nik_calon_suami", "nik_calon_istri"]);

        foreach($kpp as $p)
        {
            if($p->nik_calon_suami == $request->get("nik_calon_suami") || $p->nik_calon_istri == $request->get("nik_calon_istri") || $p->nik_calon_suami == $request->get("nik_calon_istri") || $p->nik_calon_istri == $request->get("nik_calon_suami"))
            {
                return redirect()->route('kpp.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error', 'Pendaftaran KPP Gagal. NIK Telah Terdaftar Sebelumnya.');
            }
            else
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
                $data->agama_calon_suami = $request->get("agama_calon_suami");
                $data->paroki_calon_suami = $request->get("paroki_calon_suami");
                $data->nik_calon_suami = $request->get("nik_calon_suami");
        
                //Calon Istri
                $data->nama_lengkap_calon_istri = $request->get("nama_lengkap_calon_istri");
                $data->tempat_lahir_calon_istri = $request->get("tempat_lahir_calon_istri");
                $data->tanggal_lahir_calon_istri = $request->get("tanggal_lahir_calon_istri");
                $data->nama_ayah_calon_istri = $request->get("nama_ayah_calon_istri");
                $data->nama_ibu_calon_istri = $request->get("nama_ibu_calon_istri");
                $data->alamat_calon_istri = $request->get("alamat_calon_istri");
                $data->telepon_calon_istri = $request->get("telepon_calon_istri");
                $data->agama_calon_istri = $request->get("agama_calon_istri");
                $data->paroki_calon_istri = $request->get("paroki_calon_istri");
                $data->nik_calon_istri = $request->get("nik_calon_istri");
        
                $data->keterangan_kursus = $request->get("keterangan_kursus");
                $data->lokasi = $request->get("lokasi");
                $data->status = "Disetujui Paroki";
        
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
                $riwayat->status =  "Disetujui Paroki";
                $riwayat->save();
        
                return redirect()->route('kpp.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Kursus Persiapan Perkawinan Berhasil');
            }
        }
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

    public function EditForm(Request $request)
    {
        $id = $request->id;
        $data = Kpp::where('id', $id)->first();

        return view('kpp.EditForm',compact("data"));
    }

    public function update(Request $request)
    {
        $kpp = Kpp::get(["nik_calon_suami", "nik_calon_istri"]);

        foreach($kpp as $p)
        {
            if($p->nik_calon_suami == $request->get("nik_calon_suami") || $p->nik_calon_istri == $request->get("nik_calon_istri") || $p->nik_calon_suami == $request->get("nik_calon_istri") || $p->nik_calon_istri == $request->get("nik_calon_suami"))
            {
                return redirect()->route('kpp.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error', 'Ubah Pendaftaran KPP Gagal. NIK Telah Terdaftar Sebelumnya.');
            }
            else
            {
                $data = Kpp::find($request->id);
                //Calon Suami
                $data->nama_lengkap_calon_suami = $request->get("nama_lengkap_calon_suami");
                $data->tempat_lahir_calon_suami = $request->get("tempat_lahir_calon_suami");
                $data->tanggal_lahir_calon_suami = $request->get("tanggal_lahir_calon_suami");
                $data->nama_ayah_calon_suami = $request->get("nama_ayah_calon_suami");
                $data->nama_ibu_calon_suami = $request->get("nama_ibu_calon_suami");
                $data->alamat_calon_suami = $request->get("alamat_calon_suami");
                $data->telepon_calon_suami = $request->get("telepon_calon_suami");
                $data->nik_calon_suami = $request->get("nik_calon_suami");
        
                //Calon Istri
                $data->nama_lengkap_calon_istri = $request->get("nama_lengkap_calon_istri");
                $data->tempat_lahir_calon_istri = $request->get("tempat_lahir_calon_istri");
                $data->tanggal_lahir_calon_istri = $request->get("tanggal_lahir_calon_istri");
                $data->nama_ayah_calon_istri = $request->get("nama_ayah_calon_istri");
                $data->nama_ibu_calon_istri = $request->get("nama_ibu_calon_istri");
                $data->alamat_calon_istri = $request->get("alamat_calon_istri");
                $data->telepon_calon_istri = $request->get("telepon_calon_istri");
                $data->nik_calon_istri = $request->get("nik_calon_istri");
        
                //ktp
                $file=$request->file('ktp_calon_suami');
                if(isset($file))
                {
                    $imgFolder = 'file_kpp/ktp';
                    $extension = $request->file('ktp_calon_suami')->extension();
                    $imgFile=time()."_".$request->get('nama').".".$extension;
                    $file->move($imgFolder,$imgFile);
                    $data->ktp_calon_suami=$imgFile;
                }
        
                $file2=$request->file('ktp_calon_istri');
                if(isset($file2))
                {
                    $imgFolder2 = 'file_kpp/ktp';
                    $extension2 = $request->file('ktp_calon_istri')->extension();
                    $imgFile2=time()."_".$request->get('nama').".".$extension2;
                    $file2->move($imgFolder2,$imgFile2);
                    $data->ktp_calon_istri=$imgFile2;
                }
        
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
        
                return redirect()->route('kpp.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Ubah Pendaftaran Kursus Persiapan Perkawinan Berhasil');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kpp  $kpp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kpp $kpp)
    {
        $riwayat = Riwayat::where([['event_id', $request->id],['jenis_event', 'like', 'Kursus%']])->get();
        foreach($riwayat as $r)
        {
            $r->delete();
        }
        
        $kpp=Kpp::find($request->id);
        $kpp->delete();

        return redirect()->route('kpp.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Kursus Persiapan Perkawinan Berhasil Dibatalkan');
    }
}
