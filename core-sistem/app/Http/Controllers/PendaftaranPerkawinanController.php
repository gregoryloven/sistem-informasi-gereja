<?php

namespace App\Http\Controllers;

use App\Models\Perkawinan;
use App\Models\ListEvent;
use App\Models\Riwayat;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use DB;

class PendaftaranPerkawinanController extends Controller
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
            $data = Perkawinan::where('user_id', Auth::user()->id)->get();

            return view('pendaftaranperkawinan.index',compact("data"));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role != 'umat')
        {
            return back();
        }
        else
        {
            $data = Perkawinan::where('user_id', Auth::user()->id)->first();
            if(isset($data)){
                return view('pendaftaranperkawinan.InputForm');
                // return redirect()->route('pendaftaranperkawinan.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) );
            }else{
                return view('pendaftaranperkawinan.InputForm');
            }
    
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $perkawinan = Perkawinan::where('nik_calon_suami', $request->get("nik_calon_suami"))
        ->orwhere('nik_calon_istri', $request->get("nik_calon_istri"))
        ->orwhere('nik_calon_suami', $request->get("nik_calon_istri"))
        ->orwhere('nik_calon_istri', $request->get("nik_calon_suami"))
        ->get();

        if(count($perkawinan)!=0)
        {
            return redirect()->route('pendaftaranperkawinan.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error', 'Pendaftaran Perkawinan Gagal. NIK Telah Terdaftar Sebelumnya.');
        }
        else
        {
            if($request->get("agama_calon_suami") != 'Katolik' && $request->get("agama_calon_istri") != 'Katolik')
            {
                return redirect()->route('pendaftaranperkawinan.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error', 'Pendaftaran Perkawinan Gagal. Salah Satu Calon Pasangan Harus Beragama Katolik.');
            }
            else
            {
                $data = new Perkawinan();
                $data->user_id = Auth::user()->id;
                //Calon Suami
                $data->nama_lengkap_calon_suami = $request->get("nama_lengkap_calon_suami");
                $data->tempat_lahir_calon_suami = $request->get("tempat_lahir_calon_suami");
                $data->tanggal_lahir_calon_suami = $request->get("tanggal_lahir_calon_suami");
                $data->pekerjaan_calon_suami = $request->get("pekerjaan_calon_suami");
                $data->alamat_calon_suami = $request->get("alamat_calon_suami");
                $data->telepon_calon_suami = $request->get("telepon_calon_suami");
                $data->agama_calon_suami = $request->get("agama_calon_suami");
                $data->paroki_calon_suami = $request->get("paroki_calon_suami");
                $data->nik_calon_suami = $request->get("nik_calon_suami");
        
        
                //Ortu Suami
                $data->nama_ayah_calon_suami = $request->get("nama_ayah_calon_suami");
                $data->nama_ibu_calon_suami = $request->get("nama_ibu_calon_suami");
                $data->agama_ayah_calon_suami = $request->get("agama_ayah_calon_suami");
                $data->agama_ibu_calon_suami = $request->get("agama_ibu_calon_suami");
                $data->pekerjaan_ayah_calon_suami = "abc";
                $data->alamat_orangtua_calon_suami = $request->get("alamat_orangtua_calon_suami");
        
                //Calon Istri
                $data->nama_lengkap_calon_istri = $request->get("nama_lengkap_calon_istri");
                $data->tempat_lahir_calon_istri = $request->get("tempat_lahir_calon_istri");
                $data->tanggal_lahir_calon_istri = $request->get("tanggal_lahir_calon_istri");
                $data->pekerjaan_calon_istri = $request->get("pekerjaan_calon_istri");
                $data->alamat_calon_istri = $request->get("alamat_calon_istri");
                $data->telepon_calon_istri = $request->get("telepon_calon_istri");
                $data->agama_calon_istri = $request->get("agama_calon_istri");
                $data->paroki_calon_istri = $request->get("paroki_calon_istri");
                $data->nik_calon_istri = $request->get("nik_calon_istri");
        
                //Ortu Istri
                $data->nama_ayah_calon_istri = $request->get("nama_ayah_calon_istri");
                $data->nama_ibu_calon_istri = $request->get("nama_ibu_calon_istri");
                $data->agama_ayah_calon_istri = $request->get("agama_ayah_calon_istri");
                $data->agama_ibu_calon_istri = $request->get("agama_ibu_calon_istri");
                $data->pekerjaan_ayah_calon_istri = "abc";
                $data->alamat_orangtua_calon_istri = $request->get("alamat_orangtua_calon_istri");
        
        
                //FILE
                //ktp
                $file=$request->file('ktp_calon_suami');
                $imgFolder = 'file_perkawinan/ktp';
                $extension = $request->file('ktp_calon_suami')->extension();
                $imgFile=time()."_".$request->get('nama').".".$extension;
                $file->move($imgFolder,$imgFile);
                $data->ktp_calon_suami=$imgFile;
        
                $file2=$request->file('ktp_calon_istri');
                $imgFolder2 = 'file_perkawinan/ktp';
                $extension2 = $request->file('ktp_calon_istri')->extension();
                $imgFile2=time()."_".$request->get('nama').".".$extension2;
                $file2->move($imgFolder2,$imgFile2);
                $data->ktp_calon_istri=$imgFile2;
        
                //kk
                $file3=$request->file('kk_calon_suami');
                $imgFolder3 = 'file_perkawinan/kk';
                $extension3 = $request->file('kk_calon_suami')->extension();
                $imgFile3=time()."_".$request->get('nama').".".$extension3;
                $file3->move($imgFolder3,$imgFile3);
                $data->kk_calon_suami=$imgFile3;
        
                $file4=$request->file('kk_calon_istri');
                $imgFolder4 = 'file_perkawinan/kk';
                $extension4 = $request->file('kk_calon_istri')->extension();
                $imgFile4=time()."_".$request->get('nama').".".$extension4;
                $file4->move($imgFolder4,$imgFile4);
                $data->kk_calon_istri=$imgFile4;
        
                //ttd
                $file5=$request->file('ttd_calon_suami');
                $imgFolder5 = 'file_perkawinan/ttd';
                $extension5 = $request->file('ttd_calon_suami')->extension();
                $imgFile5=time()."_".$request->get('nama').".".$extension5;
                $file5->move($imgFolder5,$imgFile5);
                $data->ttd_calon_suami=$imgFile5;
        
                $file6=$request->file('ttd_calon_istri');
                if(isset($file6))
                {
                    $imgFolder6 = 'file_perkawinan/ttd';
                    $extension6 = $request->file('ttd_calon_istri')->extension();
                    $imgFile6=time()."_".$request->get('nama').".".$extension6;
                    $file6->move($imgFolder6,$imgFile6);
                    $data->ttd_calon_istri=$imgFile6;
                }
        
                //surat baptis
                $file7=$request->file('surat_baptis_calon_suami');
                if(isset($file7))
                {
                    $imgFolder7 = 'file_perkawinan/surat_baptis';
                    $extension7 = $request->file('surat_baptis_calon_suami')->extension();
                    $imgFile7=time()."_".$request->get('nama').".".$extension7;
                    $file7->move($imgFolder7,$imgFile7);
                    $data->surat_baptis_calon_suami=$imgFile7;
                }
        
                $file8=$request->file('surat_baptis_calon_istri');
                if(isset($file8))
                {
                    $imgFolder8 = 'file_perkawinan/surat_baptis';
                    $extension8 = $request->file('surat_baptis_calon_istri')->extension();
                    $imgFile8=time()."_".$request->get('nama').".".$extension8;
                    $file8->move($imgFolder8,$imgFile8);
                    $data->surat_baptis_calon_istri=$imgFile8;
                }
        
                //sertifikat komuni
                $file9=$request->file('sertifikat_komuni_calon_suami');
                if(isset($file9))
                {
                    $imgFolder9 = 'file_perkawinan/sertifikat_komuni';
                    $extension9 = $request->file('sertifikat_komuni_calon_suami')->extension();
                    $imgFile9=time()."_".$request->get('nama').".".$extension9;
                    $file9->move($imgFolder9,$imgFile9);
                    $data->sertifikat_komuni_calon_suami=$imgFile9;
                }
        
                $file10=$request->file('sertifikat_komuni_calon_istri');
                if(isset($file10))
                {
                    $imgFolder10 = 'file_perkawinan/sertifikat_komuni';
                    $extension10 = $request->file('sertifikat_komuni_calon_istri')->extension();
                    $imgFile10=time()."_".$request->get('nama').".".$extension10;
                    $file10->move($imgFolder10,$imgFile10);
                    $data->sertifikat_komuni_calon_istri=$imgFile10;
                }
        
        
                //sertifikat krisma
                $file11=$request->file('sertifikat_krisma_calon_suami');
                if(isset($file11))
                {
                    $imgFolder11 = 'file_perkawinan/sertifikat_krisma';
                    $extension11 = $request->file('sertifikat_krisma_calon_suami')->extension();
                    $imgFile11=time()."_".$request->get('nama').".".$extension11;
                    $file11->move($imgFolder11,$imgFile11);
                    $data->sertifikat_krisma_calon_suami=$imgFile11;
                }
        
                $file12=$request->file('sertifikat_krisma_calon_istri');
                if(isset($file12))
                {
                    $imgFolder12 = 'file_perkawinan/sertifikat_krisma';
                    $extension12 = $request->file('sertifikat_krisma_calon_istri')->extension();
                    $imgFile12=time()."_".$request->get('nama').".".$extension12;
                    $file12->move($imgFolder12,$imgFile12);
                    $data->sertifikat_krisma_calon_istri=$imgFile12;
                }
        
                //surat pengantar lingkungan
                $file13=$request->file('suratpengantar_lingkungan_calon_suami');
                if(isset($file13))
                {
                    $imgFolder13 = 'file_perkawinan/suratpengantar_lingkungan';
                    $extension13 = $request->file('suratpengantar_lingkungan_calon_suami')->extension();
                    $imgFile13=time()."_".$request->get('nama').".".$extension13;
                    $file13->move($imgFolder13,$imgFile13);
                    $data->suratpengantar_lingkungan_calon_suami=$imgFile13;
                }
        
                $file14=$request->file('suratpengantar_lingkungan_calon_istri');
                if(isset($file14))
                {
                    $imgFolder14 = 'file_perkawinan/suratpengantar_lingkungan';
                    $extension14 = $request->file('suratpengantar_lingkungan_calon_istri')->extension();
                    $imgFile14=time()."_".$request->get('nama').".".$extension14;
                    $file14->move($imgFolder14,$imgFile14);
                    $data->suratpengantar_lingkungan_calon_istri=$imgFile14;
                }
        
                //surat pengantar paroki
                $file15=$request->file('suratpengantar_paroki_calon_suami');
                if(isset($file15))
                {
                    $imgFolder15 = 'file_perkawinan/suratpengantar_paroki';
                    $extension15 = $request->file('suratpengantar_paroki_calon_suami')->extension();
                    $imgFile15=time()."_".$request->get('nama').".".$extension15;
                    $file15->move($imgFolder15,$imgFile15);
                    $data->suratpengantar_paroki_calon_suami=$imgFile15;
                }
        
                $file16=$request->file('suratpengantar_paroki_calon_istri');
                if(isset($file16))
                {
                    $imgFolder16 = 'file_perkawinan/suratpengantar_paroki';
                    $extension16 = $request->file('suratpengantar_paroki_calon_istri')->extension();
                    $imgFile16=time()."_".$request->get('nama').".".$extension16;
                    $file16->move($imgFolder16,$imgFile16);
                    $data->suratpengantar_paroki_calon_istri=$imgFile16;
                }
        
                //surat keterangan bebas menikah
                $file17=$request->file('suratketerangan_bebas_menikah_calon_suami');
                if(isset($file17))
                {
                    $imgFolder17 = 'file_perkawinan/suratketerangan_bebas_menikah';
                    $extension17 = $request->file('suratketerangan_bebas_menikah_calon_suami')->extension();
                    $imgFile17=time()."_".$request->get('nama').".".$extension17;
                    $file17->move($imgFolder17,$imgFile17);
                    $data->suratketerangan_bebas_menikah_calon_suami=$imgFile17;
                }
        
                $file18=$request->file('suratketerangan_bebas_menikah_calon_istri');
                if(isset($file18))
                {
                    $imgFolder18 = 'file_perkawinan/suratketerangan_bebas_menikah';
                    $extension18 = $request->file('suratketerangan_bebas_menikah_calon_istri')->extension();
                    $imgFile18=time()."_".$request->get('nama').".".$extension18;
                    $file18->move($imgFolder18,$imgFile18);
                    $data->suratketerangan_bebas_menikah_calon_istri=$imgFile18;
                }
        
                //surat pernyataan non katolik
                $file19=$request->file('suratpernyataan_nonKatolik_calon_suami');
                if(isset($file19))
                {
                    $imgFolder19 = 'file_perkawinan/suratpernyataan_nonkatolik';
                    $extension19 = $request->file('suratpernyataan_nonKatolik_calon_suami')->extension();
                    $imgFile19=time()."_".$request->get('nama').".".$extension19;
                    $file19->move($imgFolder19,$imgFile19);
                    $data->suratpernyataan_nonKatolik_calon_suami=$imgFile19;
                }
        
                $file20=$request->file('suratpernyataan_nonKatolik_calon_istri');
                if(isset($file20))
                {
                    $imgFolder20 = 'file_perkawinan/suratpernyataan_nonkatolik';
                    $extension20 = $request->file('suratpernyataan_nonKatolik_calon_istri')->extension();
                    $imgFile20=time()."_".$request->get('nama').".".$extension20;
                    $file20->move($imgFolder20,$imgFile20);
                    $data->suratpernyataan_nonKatolik_calon_istri=$imgFile20;
                }
        
                //Hal Lain
                //sertifikat KPP
                $file21=$request->file('sertifikat_kpp');
                $imgFolder21 = 'file_perkawinan/sertifikat_kpp';
                $extension21 = $request->file('sertifikat_kpp')->extension();
                $imgFile21=time()."_".$request->get('nama').".".$extension21;
                $file21->move($imgFolder21,$imgFile21);
                $data->sertifikat_kpp=$imgFile21;
        
                //foto berdampingan
                $file22=$request->file('foto_berdampingan');
                $imgFolder22 = 'file_perkawinan/foto_berdampingan';
                $extension22 = $request->file('foto_berdampingan')->extension();
                $imgFile22=time()."_".$request->get('nama').".".$extension22;
                $file22->move($imgFolder22,$imgFile22);
                $data->foto_berdampingan=$imgFile22;
        
                //ktp saksi nikah
                $file23=$request->file('ktp_saksi_nikah');
                $imgFolder23 = 'file_perkawinan/ktp_saksi_nikah';
                $extension23 = $request->file('ktp_saksi_nikah')->extension();
                $imgFile23=time()."_".$request->get('nama').".".$extension23;
                $file23->move($imgFolder23,$imgFile23);
                $data->ktp_saksi_nikah=$imgFile23;
        
                $data->tanggal_kanonik = $request->get("tanggal_kanonik");
                $data->tempat_perkawinan = $request->get("tempat_perkawinan");
                $data->tanggal_perkawinan = $request->get("tanggal_perkawinan");
                $data->status = "Diproses";
        
                $data->save();
        
                $list =  new ListEvent();
                $list->nama_event = "Perkawinan";
                $list->jenis_event = "Perkawinan";
                $list->jadwal_pelaksanaan = $data->tanggal_perkawinan;
                $list->lokasi = $data->tempat_perkawinan;
                $list->status = "Pending";
                $list->save();
        
                $riwayat = new Riwayat();
                $riwayat->user_id = Auth::user()->id;
                $riwayat->list_event_id = $list->id;
                $riwayat->event_id =  $data->id;
                $riwayat->jenis_event = "Perkawinan";
                $riwayat->status =  "Diproses";
                $riwayat->save();
        
                return redirect()->route('pendaftaranperkawinan.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Perkawinan Berhasil');
            }   
        }
    }

    public function detail(Request $request)
    {
        $id=$request->get("id");
        $log = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
        ->where([['event_id', '=', $id], ['riwayats.jenis_event', '=', 'Perkawinan']])
        ->get('riwayats.*');
        
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('pendaftaranperkawinan.detail', compact("log"))->render()),200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Perkawinan  $perkawinan
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Perkawinan  $perkawinan
     * @return \Illuminate\Http\Response
     */
    public function edit(Perkawinan $perkawinan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Perkawinan  $perkawinan
     * @return \Illuminate\Http\Response
     */

    public function EditForm(Request $request)
    {
        $id = $request->id;
        $data = Perkawinan::where('id', $id)->first();

        return view('pendaftaranperkawinan.EditForm',compact("data"));
    }

    public function update(Request $request)
    {
        $perkawinan = Perkawinan::where('nik_calon_suami', $request->get("nik_calon_suami"))
        ->orwhere('nik_calon_istri', $request->get("nik_calon_istri"))
        ->orwhere('nik_calon_suami', $request->get("nik_calon_istri"))
        ->orwhere('nik_calon_istri', $request->get("nik_calon_suami"))
        ->get();

        if(count($perkawinan)!=1)
        {
            return redirect()->route('pendaftaranperkawinan.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error', 'Ubah Pendaftaran Perkawinan Gagal. NIK Telah Terdaftar Sebelumnya.');
        }
        else
        {
            $data=Perkawinan::find($request->id);

            //Calon Suami
            $data->nama_lengkap_calon_suami = $request->get("nama_lengkap_calon_suami");
            $data->tempat_lahir_calon_suami = $request->get("tempat_lahir_calon_suami");
            $data->tanggal_lahir_calon_suami = $request->get("tanggal_lahir_calon_suami");
            $data->pekerjaan_calon_suami = $request->get("pekerjaan_calon_suami");
            $data->alamat_calon_suami = $request->get("alamat_calon_suami");
            $data->telepon_calon_suami = $request->get("telepon_calon_suami");
            $data->nik_calon_suami = $request->get("nik_calon_suami");
    
            //Ortu Suami
            $data->nama_ayah_calon_suami = $request->get("nama_ayah_calon_suami");
            $data->nama_ibu_calon_suami = $request->get("nama_ibu_calon_suami");
            $data->agama_ayah_calon_suami = $request->get("agama_ayah_calon_suami");
            $data->agama_ibu_calon_suami = $request->get("agama_ibu_calon_suami");
            $data->pekerjaan_ayah_calon_suami = "abc";
            $data->alamat_orangtua_calon_suami = $request->get("alamat_orangtua_calon_suami");
    
            //Calon Istri
            $data->nama_lengkap_calon_istri = $request->get("nama_lengkap_calon_istri");
            $data->tempat_lahir_calon_istri = $request->get("tempat_lahir_calon_istri");
            $data->tanggal_lahir_calon_istri = $request->get("tanggal_lahir_calon_istri");
            $data->pekerjaan_calon_istri = $request->get("pekerjaan_calon_istri");
            $data->alamat_calon_istri = $request->get("alamat_calon_istri");
            $data->telepon_calon_istri = $request->get("telepon_calon_istri");
            $data->nik_calon_istri = $request->get("nik_calon_istri");
    
            //Ortu Istri
            $data->nama_ayah_calon_istri = $request->get("nama_ayah_calon_istri");
            $data->nama_ibu_calon_istri = $request->get("nama_ibu_calon_istri");
            $data->agama_ayah_calon_istri = $request->get("agama_ayah_calon_istri");
            $data->agama_ibu_calon_istri = $request->get("agama_ibu_calon_istri");
            $data->pekerjaan_ayah_calon_istri = "abc";
            $data->alamat_orangtua_calon_istri = $request->get("alamat_orangtua_calon_istri");
    
    
            //FILE
            //ktp
            $file=$request->file('ktp_calon_suami');
            if(isset($file))
            {
                $imgFolder = 'file_perkawinan/ktp';
                $extension = $request->file('ktp_calon_suami')->extension();
                $imgFile=time()."_".$request->get('nama').".".$extension;
                $file->move($imgFolder,$imgFile);
                $data->ktp_calon_suami=$imgFile;
            }
    
            $file2=$request->file('ktp_calon_istri');
            if(isset($file2))
            {
                $imgFolder2 = 'file_perkawinan/ktp';
                $extension2 = $request->file('ktp_calon_istri')->extension();
                $imgFile2=time()."_".$request->get('nama').".".$extension2;
                $file2->move($imgFolder2,$imgFile2);
                $data->ktp_calon_istri=$imgFile2;
            }
    
            //kk
            $file3=$request->file('kk_calon_suami');
            if(isset($file3))
            {
                $imgFolder3 = 'file_perkawinan/kk';
                $extension3 = $request->file('kk_calon_suami')->extension();
                $imgFile3=time()."_".$request->get('nama').".".$extension3;
                $file3->move($imgFolder3,$imgFile3);
                $data->kk_calon_suami=$imgFile3;
            }
    
            $file4=$request->file('kk_calon_istri');
            if(isset($file4))
            {
                $imgFolder4 = 'file_perkawinan/kk';
                $extension4 = $request->file('kk_calon_istri')->extension();
                $imgFile4=time()."_".$request->get('nama').".".$extension4;
                $file4->move($imgFolder4,$imgFile4);
                $data->kk_calon_istri=$imgFile4;
            }
    
            //ttd
            $file5=$request->file('ttd_calon_suami');
            if(isset($file5))
            {
                $imgFolder5 = 'file_perkawinan/ttd';
                $extension5 = $request->file('ttd_calon_suami')->extension();
                $imgFile5=time()."_".$request->get('nama').".".$extension5;
                $file5->move($imgFolder5,$imgFile5);
                $data->ttd_calon_suami=$imgFile5;
            }
    
            $file6=$request->file('ttd_calon_istri');
            if(isset($file6))
            {
                $imgFolder6 = 'file_perkawinan/ttd';
                $extension6 = $request->file('ttd_calon_istri')->extension();
                $imgFile6=time()."_".$request->get('nama').".".$extension6;
                $file6->move($imgFolder6,$imgFile6);
                $data->ttd_calon_istri=$imgFile6;
            }
    
            //surat baptis
            $file7=$request->file('surat_baptis_calon_suami');
            if(isset($file7))
            {
                $imgFolder7 = 'file_perkawinan/surat_baptis';
                $extension7 = $request->file('surat_baptis_calon_suami')->extension();
                $imgFile7=time()."_".$request->get('nama').".".$extension7;
                $file7->move($imgFolder7,$imgFile7);
                $data->surat_baptis_calon_suami=$imgFile7;
            }
    
            $file8=$request->file('surat_baptis_calon_istri');
            if(isset($file8))
            {
                $imgFolder8 = 'file_perkawinan/surat_baptis';
                $extension8 = $request->file('surat_baptis_calon_istri')->extension();
                $imgFile8=time()."_".$request->get('nama').".".$extension8;
                $file8->move($imgFolder8,$imgFile8);
                $data->surat_baptis_calon_istri=$imgFile8;
            }
    
            //sertifikat komuni
            $file9=$request->file('sertifikat_komuni_calon_suami');
            if(isset($file9))
            {
                $imgFolder9 = 'file_perkawinan/sertifikat_komuni';
                $extension9 = $request->file('sertifikat_komuni_calon_suami')->extension();
                $imgFile9=time()."_".$request->get('nama').".".$extension9;
                $file9->move($imgFolder9,$imgFile9);
                $data->sertifikat_komuni_calon_suami=$imgFile9;
            }
    
            $file10=$request->file('sertifikat_komuni_calon_istri');
            if(isset($file10))
            {
                $imgFolder10 = 'file_perkawinan/sertifikat_komuni';
                $extension10 = $request->file('sertifikat_komuni_calon_istri')->extension();
                $imgFile10=time()."_".$request->get('nama').".".$extension10;
                $file10->move($imgFolder10,$imgFile10);
                $data->sertifikat_komuni_calon_istri=$imgFile10;
            }
    
    
            //sertifikat krisma
            $file11=$request->file('sertifikat_krisma_calon_suami');
            if(isset($file11))
            {
                $imgFolder11 = 'file_perkawinan/sertifikat_krisma';
                $extension11 = $request->file('sertifikat_krisma_calon_suami')->extension();
                $imgFile11=time()."_".$request->get('nama').".".$extension11;
                $file11->move($imgFolder11,$imgFile11);
                $data->sertifikat_krisma_calon_suami=$imgFile11;
            }
    
            $file12=$request->file('sertifikat_krisma_calon_istri');
            if(isset($file12))
            {
                $imgFolder12 = 'file_perkawinan/sertifikat_krisma';
                $extension12 = $request->file('sertifikat_krisma_calon_istri')->extension();
                $imgFile12=time()."_".$request->get('nama').".".$extension12;
                $file12->move($imgFolder12,$imgFile12);
                $data->sertifikat_krisma_calon_istri=$imgFile12;
            }
    
            //surat pengantar lingkungan
            $file13=$request->file('suratpengantar_lingkungan_calon_suami');
            if(isset($file13))
            {
                $imgFolder13 = 'file_perkawinan/suratpengantar_lingkungan';
                $extension13 = $request->file('suratpengantar_lingkungan_calon_suami')->extension();
                $imgFile13=time()."_".$request->get('nama').".".$extension13;
                $file13->move($imgFolder13,$imgFile13);
                $data->suratpengantar_lingkungan_calon_suami=$imgFile13;
            }
    
            $file14=$request->file('suratpengantar_lingkungan_calon_istri');
            if(isset($file14))
            {
                $imgFolder14 = 'file_perkawinan/suratpengantar_lingkungan';
                $extension14 = $request->file('suratpengantar_lingkungan_calon_istri')->extension();
                $imgFile14=time()."_".$request->get('nama').".".$extension14;
                $file14->move($imgFolder14,$imgFile14);
                $data->suratpengantar_lingkungan_calon_istri=$imgFile14;
            }
    
            //surat pengantar paroki
            $file15=$request->file('suratpengantar_paroki_calon_suami');
            if(isset($file15))
            {
                $imgFolder15 = 'file_perkawinan/suratpengantar_paroki';
                $extension15 = $request->file('suratpengantar_paroki_calon_suami')->extension();
                $imgFile15=time()."_".$request->get('nama').".".$extension15;
                $file15->move($imgFolder15,$imgFile15);
                $data->suratpengantar_paroki_calon_suami=$imgFile15;
            }
    
            $file16=$request->file('suratpengantar_paroki_calon_istri');
            if(isset($file16))
            {
                $imgFolder16 = 'file_perkawinan/suratpengantar_paroki';
                $extension16 = $request->file('suratpengantar_paroki_calon_istri')->extension();
                $imgFile16=time()."_".$request->get('nama').".".$extension16;
                $file16->move($imgFolder16,$imgFile16);
                $data->suratpengantar_paroki_calon_istri=$imgFile16;
            }
    
            //surat keterangan bebas menikah
            $file17=$request->file('suratketerangan_bebas_menikah_calon_suami');
            if(isset($file17))
            {
                $imgFolder17 = 'file_perkawinan/suratketerangan_bebas_menikah';
                $extension17 = $request->file('suratketerangan_bebas_menikah_calon_suami')->extension();
                $imgFile17=time()."_".$request->get('nama').".".$extension17;
                $file17->move($imgFolder17,$imgFile17);
                $data->suratketerangan_bebas_menikah_calon_suami=$imgFile17;
            }
    
            $file18=$request->file('suratketerangan_bebas_menikah_calon_istri');
            if(isset($file18))
            {
                $imgFolder18 = 'file_perkawinan/suratketerangan_bebas_menikah';
                $extension18 = $request->file('suratketerangan_bebas_menikah_calon_istri')->extension();
                $imgFile18=time()."_".$request->get('nama').".".$extension18;
                $file18->move($imgFolder18,$imgFile18);
                $data->suratketerangan_bebas_menikah_calon_istri=$imgFile18;
            }
    
            //surat pernyataan non katolik
            $file19=$request->file('suratpernyataan_nonKatolik_calon_suami');
            if(isset($file19))
            {
                $imgFolder19 = 'file_perkawinan/suratpernyataan_nonkatolik';
                $extension19 = $request->file('suratpernyataan_nonKatolik_calon_suami')->extension();
                $imgFile19=time()."_".$request->get('nama').".".$extension19;
                $file19->move($imgFolder19,$imgFile19);
                $data->suratpernyataan_nonKatolik_calon_suami=$imgFile19;
            }
    
            $file20=$request->file('suratpernyataan_nonKatolik_calon_istri');
            if(isset($file20))
            {
                $imgFolder20 = 'file_perkawinan/suratpernyataan_nonkatolik';
                $extension20 = $request->file('suratpernyataan_nonKatolik_calon_istri')->extension();
                $imgFile20=time()."_".$request->get('nama').".".$extension20;
                $file20->move($imgFolder20,$imgFile20);
                $data->suratpernyataan_nonKatolik_calon_istri=$imgFile20;
            }
    
            //Hal Lain
            //sertifikat KPP
            $file21=$request->file('sertifikat_kpp');
            if(isset($file21))
            {
                $imgFolder21 = 'file_perkawinan/sertifikat_kpp';
                $extension21 = $request->file('sertifikat_kpp')->extension();
                $imgFile21=time()."_".$request->get('nama').".".$extension21;
                $file21->move($imgFolder21,$imgFile21);
                $data->sertifikat_kpp=$imgFile21;
            }
    
            //foto berdampingan
            $file22=$request->file('foto_berdampingan');
            if(isset($file21))
            {
                $imgFolder22 = 'file_perkawinan/foto_berdampingan';
                $extension22 = $request->file('foto_berdampingan')->extension();
                $imgFile22=time()."_".$request->get('nama').".".$extension22;
                $file22->move($imgFolder22,$imgFile22);
                $data->foto_berdampingan=$imgFile22;
            }
    
            //ktp saksi nikah
            $file23=$request->file('ktp_saksi_nikah');
            if(isset($file21))
            {
                $imgFolder23 = 'file_perkawinan/ktp_saksi_nikah';
                $extension23 = $request->file('ktp_saksi_nikah')->extension();
                $imgFile23=time()."_".$request->get('nama').".".$extension23;
                $file23->move($imgFolder23,$imgFile23);
                $data->ktp_saksi_nikah=$imgFile23;
            }
    
            $data->tanggal_kanonik = $request->get("tanggal_kanonik");
            $data->tanggal_perkawinan = $request->get("tanggal_perkawinan");
    
            $data->save();
    
            $list =  ListEvent::join('riwayats', 'list_events.id', '=', 'riwayats.list_event_id')
            ->join('perkawinans', 'riwayats.event_id', '=', 'perkawinans.id')
            ->where('riwayats.event_id', $data->id)
            ->first();
            $list->jadwal_pelaksanaan = $data->tanggal_perkawinan;
            $list->save();
    
            return redirect()->route('pendaftaranperkawinan.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Ubah Data Pendaftaran Perkawinan Berhasil');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Perkawinan  $perkawinan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $riwayat = Riwayat::where([['event_id', $request->id],['jenis_event', 'Perkawinan']])->get();
        foreach($riwayat as $r)
        {
            $r->delete();
        }

        $list_event = ListEvent::where('jadwal_pelaksanaan', $request->jadwal)->first();
        $list_event->delete();
        
        $perkawinan=Perkawinan::find($request->id);
        $perkawinan->delete();

        return redirect()->route('pendaftaranperkawinan.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Perkawinan Berhasil Dibatalkan');
    }
}
