<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KomuniPertama;
use App\Models\User;
use App\Models\Riwayat;
use Auth;
use DB;

class KomuniPertamaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('list_events')
        ->where('jenis_event', 'like', 'Ko%')
        ->get();

        $user = Auth::user()->id;
        $komuni = DB::table('komuni_pertamas')
        ->join('riwayats', 'komuni_pertamas.id', '=', 'riwayats.event_id')
        ->where([['riwayats.status', 'Disetujui Paroki'], ['riwayats.jenis_event', 'like', 'Ko%']])
        ->orwhere([['riwayats.status', 'Dibatalkan'], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'like', 'Ko%']])
        ->orderBy('komuni_pertamas.jadwal', 'DESC')
        ->get(['komuni_pertamas.*', 'riwayats.id as riwayatID', 'riwayats.status as statusRiwayat', 
        'riwayats.created_at', 'riwayats.updated_at', 'riwayats.alasan_pembatalan']);

        return view('komunipertama.index',compact("data", "komuni"));
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

        return view('komunipertama.InputForm',compact("list", "user"));
    }

    public function store(Request $request)
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
        $data->status = "Disetujui Paroki";
        $file=$request->file('surat_baptis');

        $imgFolder = 'file_sertifikat/surat_baptis';
        $extension = $request->file('surat_baptis')->extension();
        $imgFile=time()."_".$request->get('nama').".".$extension;
        $file->move($imgFolder,$imgFile);
        $data->surat_baptis=$imgFile;

        $data->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->jenis_event =  $request->get("jenis_event");
        $riwayat->event_id =  $data->id;
        $riwayat->status =  "Disetujui Paroki";
        $riwayat->save();

        return redirect()->route('komunipertama.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Komuni Pertama Berhasil Ditambahkan');
    }

    public function EditForm(Request $request)
    {
        $id=$request->get("id");
        $data=KomuniPertama::find($id);
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('komunipertama.EditForm',compact("data"))->render()),200);
    }

    public function update(Request $request)
    {
        $komuni=KomuniPertama::find($request->id);
        $komuni->nama_lengkap = $request->get("nama_lengkap");
        $komuni->tempat_lahir = $request->get("tempat_lahir");
        $komuni->tanggal_lahir = $request->get("tanggal_lahir");
        $komuni->orangtua_ayah = $request->get("orangtua_ayah");
        $komuni->orangtua_ibu = $request->get("orangtua_ibu");
        $komuni->lingkungan = $request->get("lingkungan");
        $komuni->kbg = $request->get("kbg");
        $komuni->telepon = $request->get("telepon");
        $komuni->jadwal = $request->get("jadwal");
        $komuni->lokasi = $request->get("lokasi");
        $komuni->romo = $request->get("romo");
        $komuni->status = "Disetujui Paroki";

        $file=$request->file('surat_baptis');
        if(isset($file))
        {
            $imgFolder = 'file_sertifikat/surat_baptis';
            $extension = $request->file('surat_baptis')->extension();
            $imgFile=time()."_".$request->get('nama').".".$extension;
            $file->move($imgFolder,$imgFile);
            $komuni->surat_baptis=$imgFile;
            
        }

        $komuni->save();
        
        return redirect()->route('komunipertama.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Data Pendaftaran Komuni Pertama Berhasil Diubah');
    }

    public function Pembatalan(Request $request)
    {
        $data=KomuniPertama::find($request->id);
        $data->status = "Dibatalkan";
        $data->save();

        $riwayat = Riwayat::find($request->riwayatID);
        $riwayat->user_id = Auth::user()->id;
        $riwayat->event_id =  $data->id;
        $riwayat->jenis_event =  "Komuni Pertama";
        $riwayat->status =  "Dibatalkan";
        $riwayat->alasan_pembatalan = $request->get("alasan_pembatalan");
        $riwayat->save();

        return redirect()->route('komunipertama.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Komuni Pertama Berhasil Dibatalkan');
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
     * Display the specified resource.
     *
     * @param  \App\Models\KomuniPertama  $komuniPertama
     * @return \Illuminate\Http\Response
     */
    public function show(KomuniPertama $komuniPertama)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KomuniPertama  $komuniPertama
     * @return \Illuminate\Http\Response
     */
    public function edit(KomuniPertama $komuniPertama)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KomuniPertama  $komuniPertama
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $komunipertama=KomuniPertama::find($request->id);
        try
        {
            $komunipertama->delete();
            return redirect()->route('komunipertamas.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Data Komuni Pertama Berhasil Dihapus');
        
        }
        catch(\Exception $e)
        {
            $komunipertama = "Gagal Menghapus Data Komuni Pertama";
            return redirect()->route('komunipertamas.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error', $msg);    
        }
    }
}
