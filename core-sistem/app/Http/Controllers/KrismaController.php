<?php

namespace App\Http\Controllers;

use App\Models\Krisma;
use App\Models\Riwayat;
use App\Models\ListEvent;
use Illuminate\Http\Request;
use Auth;
use DB;

class KrismaController extends Controller
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
            $data = ListEvent::where([['jenis_event', 'like', 'Kr%'], ['status', 'Aktif']])
            ->orderBy('jadwal_pelaksanaan', 'ASC')
            ->get();
    
            $user = Auth::user()->id;
            $krisma = DB::table('krismas')
            ->join('riwayats', 'krismas.id', '=', 'riwayats.event_id')
            ->join('users', 'riwayats.user_id', '=', 'users.id')
            ->where([['riwayats.status', 'Disetujui Paroki'], ['riwayats.jenis_event', 'Krisma Setempat']])
            ->orwhere([['riwayats.status', 'Dibatalkan'], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Krisma Setempat']])
            ->orderBy('krismas.jadwal', 'DESC')
            ->get(['krismas.*', 'riwayats.id as riwayatID', 'riwayats.status as statusRiwayat', 
            'riwayats.created_at', 'riwayats.updated_at', 'riwayats.alasan_pembatalan', 'users.role']);
    
            $krisma2 = DB::table('krismas')
            ->join('riwayats', 'krismas.id', '=', 'riwayats.event_id')
            ->join('users', 'riwayats.user_id', '=', 'users.id')
            ->where([['riwayats.status', 'Disetujui Paroki'], ['riwayats.jenis_event', 'Krisma Lintas']])
            ->orwhere([['riwayats.status', 'Dibatalkan'], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'Krisma Lintas']])
            ->orderBy('krismas.jadwal', 'DESC')
            ->get(['krismas.*', 'riwayats.id as riwayatID', 'riwayats.status as statusRiwayat', 
            'riwayats.created_at', 'riwayats.updated_at', 'riwayats.alasan_pembatalan', 'users.role']);
    
            return view('krisma.index',compact("data","krisma","krisma2"));
        }
    }

    public function OpenForm(Request $request)
    {
        $id = $request->id;
        $list = DB::table('list_events')->where('id', $id)->get();

        return view('krisma.InputForm',compact("list"));
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
        $data->jenis = "Paroki Setempat";
        $data->jadwal = $request->get("jadwal");
        $data->lokasi = $request->get("lokasi");
        $data->romo = $request->get("romo");
        $data->status = "Disetujui Paroki";

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
        $riwayat->jenis_event =  "Krisma Setempat";
        $riwayat->event_id =  $data->id;
        $riwayat->status =  "Disetujui Paroki";
        $riwayat->save();

        return redirect()->route('krisma.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Krisma Berhasil');
    }

    public function InputFormLintas(Request $request)
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
        $data->jenis = "Lintas Paroki";
        $data->jadwal = $request->get("jadwal");
        $data->lokasi = $request->get("lokasi");
        $data->romo = $request->get("romo");
        $data->status = "Disetujui Paroki";

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

        $file3=$request->file('surat_pengantar');
        $imgFolder3 = 'file_sertifikat/surat_pengantar';
        $extension3 = $request->file('surat_pengantar')->extension();
        $imgFile3=time()."_".$request->get('nama').".".$extension;
        $file3->move($imgFolder3,$imgFile3);
        $data->surat_pengantar=$imgFile3;
        
        $data->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->jenis_event =  "Krisma Lintas";
        $riwayat->event_id =  $data->id;
        $riwayat->status =  "Disetujui Paroki";
        $riwayat->save();

        return redirect()->route('krisma.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Krisma Berhasil');
    }

    public function EditForm(Request $request)
    {
        $id=$request->get("id");
        $data=Krisma::find($id);
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('krisma.EditForm',compact("data"))->render()),200);
    }

    public function EditForm2(Request $request)
    {
        $id=$request->get("id");
        $data=Krisma::find($id);
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('krisma.EditForm2',compact("data"))->render()),200);
    }

    // public function UpdateSetempat(Request $request)
    // {
    //     $data=Krisma::find($request->id);
    //     $data->nama_lengkap = $request->get("nama_lengkap");
    //     $data->tempat_lahir = $request->get("tempat_lahir");
    //     $data->tanggal_lahir = $request->get("tanggal_lahir");
    //     $data->orangtua_ayah = $request->get("orangtua_ayah");
    //     $data->orangtua_ibu = $request->get("orangtua_ibu");
    //     $data->lingkungan = $request->get("lingkungan");
    //     $data->kbg = $request->get("kbg");
    //     $data->telepon = $request->get("telepon");
    //     $data->status = "Disetujui Paroki";

    //     $file=$request->file('surat_baptis');
    //     $imgFolder = 'file_sertifikat/surat_baptis';
    //     $extension = $request->file('surat_baptis')->extension();
    //     $imgFile=time()."_".$request->get('nama').".".$extension;
    //     $file->move($imgFolder,$imgFile);
    //     $data->surat_baptis=$imgFile;

    //     $file2=$request->file('sertifikat_komuni');
    //     $imgFolder2 = 'file_sertifikat/sertifikat_komuni';
    //     $extension2 = $request->file('sertifikat_komuni')->extension();
    //     $imgFile2=time()."_".$request->get('nama').".".$extension;
    //     $file2->move($imgFolder2,$imgFile2);
    //     $data->sertifikat_komuni=$imgFile2;
        
    //     $data->save();
        
    //     return redirect()->route('krisma.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Data Pendaftaran Krisma Paroki Setempat Berhasil Diubah');
    // }

    // public function UpdateLintas(Request $request)
    // {
    //     $data=Krisma::find($request->id);
    //     $data->nama_lengkap = $request->get("nama_lengkap");
    //     $data->tempat_lahir = $request->get("tempat_lahir");
    //     $data->tanggal_lahir = $request->get("tanggal_lahir");
    //     $data->orangtua_ayah = $request->get("orangtua_ayah");
    //     $data->orangtua_ibu = $request->get("orangtua_ibu");
    //     $data->lingkungan = $request->get("lingkungan");
    //     $data->kbg = $request->get("kbg");
    //     $data->telepon = $request->get("telepon");
    //     $data->status = "Disetujui Paroki";

    //     $file=$request->file('surat_baptis');
    //     $imgFolder = 'file_sertifikat/surat_baptis';
    //     $extension = $request->file('surat_baptis')->extension();
    //     $imgFile=time()."_".$request->get('nama').".".$extension;
    //     $file->move($imgFolder,$imgFile);
    //     $data->surat_baptis=$imgFile;

    //     $file2=$request->file('sertifikat_komuni');
    //     $imgFolder2 = 'file_sertifikat/sertifikat_komuni';
    //     $extension2 = $request->file('sertifikat_komuni')->extension();
    //     $imgFile2=time()."_".$request->get('nama').".".$extension;
    //     $file2->move($imgFolder2,$imgFile2);
    //     $data->sertifikat_komuni=$imgFile2;

    //     $file3=$request->file('surat_pengantar');
    //     $imgFolder3 = 'file_sertifikat/surat_pengantar';
    //     $extension3 = $request->file('surat_pengantar')->extension();
    //     $imgFile3=time()."_".$request->get('nama').".".$extension;
    //     $file3->move($imgFolder3,$imgFile3);
    //     $data->surat_pengantar=$imgFile3;
        
    //     $data->save();
        
    //     return redirect()->route('krisma.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Data Pendaftaran Krisma Lintas Paroki Berhasil Diubah');
    // }

    public function update(Request $request)
    {
        $data=Krisma::find($request->id);
        if($data->jenis == "Paroki Setempat")
        {
            $data->nama_lengkap = $request->get("nama_lengkap");
            $data->tempat_lahir = $request->get("tempat_lahir");
            $data->tanggal_lahir = $request->get("tanggal_lahir");
            $data->orangtua_ayah = $request->get("orangtua_ayah");
            $data->orangtua_ibu = $request->get("orangtua_ibu");
            $data->lingkungan = $request->get("lingkungan");
            $data->kbg = $request->get("kbg");
            $data->telepon = $request->get("telepon");
            $data->status = "Disetujui Paroki";

            $file=$request->file('surat_baptis');
            if(isset($file)){
                $imgFolder = 'file_sertifikat/surat_baptis';
                $extension = $request->file('surat_baptis')->extension();
                $imgFile=time()."_".$request->get('nama').".".$extension;
                $file->move($imgFolder,$imgFile);
                $data->surat_baptis=$imgFile;
            }

            $file2=$request->file('sertifikat_komuni');
            if(isset($file2))
            {
                $imgFolder2 = 'file_sertifikat/sertifikat_komuni';
                $extension2 = $request->file('sertifikat_komuni')->extension();
                $imgFile2=time()."_".$request->get('nama').".".$extension;
                $file2->move($imgFolder2,$imgFile2);
                $data->sertifikat_komuni=$imgFile2;
            }

            $data->save();
            
            return redirect()->route('krisma.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Data Pendaftaran Krisma Paroki Setempat Berhasil Diubah');
        }
        else
        {
            $data->nama_lengkap = $request->get("nama_lengkap");
            $data->tempat_lahir = $request->get("tempat_lahir");
            $data->tanggal_lahir = $request->get("tanggal_lahir");
            $data->orangtua_ayah = $request->get("orangtua_ayah");
            $data->orangtua_ibu = $request->get("orangtua_ibu");
            $data->lingkungan = $request->get("lingkungan");
            $data->kbg = $request->get("kbg");
            $data->telepon = $request->get("telepon");
            $data->status = "Disetujui Paroki";

            $file=$request->file('surat_baptis');
            if(isset($file)){
                $imgFolder = 'file_sertifikat/surat_baptis';
                $extension = $request->file('surat_baptis')->extension();
                $imgFile=time()."_".$request->get('nama').".".$extension;
                $file->move($imgFolder,$imgFile);
                $data->surat_baptis=$imgFile;
            }
            
            $file2=$request->file('sertifikat_komuni');
            if(isset($file2))
            {
                $imgFolder2 = 'file_sertifikat/sertifikat_komuni';
                $extension2 = $request->file('sertifikat_komuni')->extension();
                $imgFile2=time()."_".$request->get('nama').".".$extension;
                $file2->move($imgFolder2,$imgFile2);
                $data->sertifikat_komuni=$imgFile2;
            }

            $file3=$request->file('surat_pengantar');
            if(isset($file3))
            {
                $imgFolder3 = 'file_sertifikat/surat_pengantar';
                $extension3 = $request->file('surat_pengantar')->extension();
                $imgFile3=time()."_".$request->get('nama').".".$extension;
                $file3->move($imgFolder3,$imgFile3);
                $data->surat_pengantar=$imgFile3;
            }

            $data->save();
            
            return redirect()->route('krisma.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Data Pendaftaran Krisma Lintas Paroki Berhasil Diubah');
        }
    }

    public function PembatalanSetempat(Request $request)
    {
        $data=Krisma::find($request->id);
        $data->status = "Dibatalkan";

        $riwayat = Riwayat::find($request->riwayatID);
        $riwayat->user_id = Auth::user()->id;
        $riwayat->event_id =  $data->id;
        $riwayat->jenis_event =  "Krisma Setempat";
        $riwayat->status =  "Dibatalkan";
        $riwayat->alasan_pembatalan = $request->get("alasan_pembatalan");
        $riwayat->save();
        $data->save();

        return redirect()->route('krisma.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pembatalan Krisma Berhasil Dibatalkan');
    }

    public function PembatalanLintas(Request $request)
    {
        $data=Krisma::find($request->id);
        $data->status = "Dibatalkan";

        $riwayat = Riwayat::find($request->riwayatID);
        $riwayat->user_id = Auth::user()->id;
        $riwayat->event_id =  $data->id;
        $riwayat->jenis_event =  "Krisma Lintas";
        $riwayat->status =  "Dibatalkan";
        $riwayat->alasan_pembatalan = $request->get("alasan_pembatalan");
        $riwayat->save();
        $data->save();

        return redirect()->route('krisma.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pembatalan Krisma Lintas Paroki Berhasil Dibatalkan');
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
     * @param  \App\Models\Krisma  $krisma
     * @return \Illuminate\Http\Response
     */
    public function show(Krisma $krisma)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Krisma  $krisma
     * @return \Illuminate\Http\Response
     */
    public function edit(Krisma $krisma)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Krisma  $krisma
     * @return \Illuminate\Http\Response
     */
    public function destroy(Krisma $krisma)
    {
        $krisma=Krisma::find($request->id);
        try
        {
            $krisma->delete();
            return redirect()->route('krismas.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Data Krisma Berhasil Dihapus');
        
        }
        catch(\Exception $e)
        {
            $krisma = "Gagal Menghapus Data Krisma";
            return redirect()->route('krismas.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error', $msg);    
        }
    }
}
