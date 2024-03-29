<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KomuniPertama;
use App\Models\User;
use App\Models\Riwayat;
use App\Models\ListEvent;
use App\Models\Kbg;
use App\Models\Lingkungan;
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
        if(Auth::user()->role != 'admin')
        {
            return back();
        }
        else
        {
            $data = ListEvent::where([['jenis_event', 'like', 'Ko%'], ['status', 'Aktif']])
            ->orderBy('jadwal_pelaksanaan', 'ASC')
            ->get();
    
            // $user = Auth::user()->id;
            // $komuni = DB::table('komuni_pertamas')
            // ->join('riwayats', 'komuni_pertamas.id', '=', 'riwayats.event_id')
            // ->where([['riwayats.status', 'Disetujui Paroki'], ['riwayats.jenis_event', 'like', 'Ko%']])
            // ->orwhere([['riwayats.status', 'Dibatalkan'], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'like', 'Ko%']])
            // ->orderBy('komuni_pertamas.jadwal', 'DESC')
            // ->get(['komuni_pertamas.*', 'riwayats.id as riwayatID', 'riwayats.status as statusRiwayat', 
            // 'riwayats.created_at', 'riwayats.updated_at', 'riwayats.alasan_pembatalan']);

            $komuni = KomuniPertama::where([['status', 'Disetujui Paroki'], ['user_id', Auth::user()->id]])
            ->orderby('jadwal', 'ASC')
            ->get();
    
            return view('komunipertama.index',compact("data", "komuni"));
        }
    }

    public function OpenForm(Request $request)
    {
        $id = $request->id;
        $list = ListEvent::where('id', $id)->get();
        $kbg = Kbg::all();
        $ling = Lingkungan::all();

        return view('komunipertama.InputForm',compact("list", "kbg", "ling"));
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

        // $riwayat = new Riwayat();
        // $riwayat->user_id = Auth::user()->id;
        // $riwayat->jenis_event =  $request->get("jenis_event");
        // $riwayat->event_id =  $data->id;
        // $riwayat->status =  "Disetujui Paroki";
        // $riwayat->save();

        return redirect()->route('komunipertama.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Komuni Pertama Berhasil');
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
            return redirect()->route('komunipertama.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Data Komuni Pertama Berhasil Dihapus');
        
        }
        catch(\Exception $e)
        {
            $komunipertama = "Gagal Menghapus Data Komuni Pertama";
            return redirect()->route('komunipertama.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error', $msg);    
        }
    }
}
