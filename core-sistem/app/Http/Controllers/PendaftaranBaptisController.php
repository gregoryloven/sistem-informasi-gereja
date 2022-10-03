<?php

namespace App\Http\Controllers;

use App\Models\ListEvent;
use App\Models\Baptis;
use App\Models\User;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class PendaftaranBaptisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('list_events')
                ->where('jenis_event', 'like', 'Baptis B%')
                ->get();
        $baptis = Baptis::where([['user_id', Auth::user()->id], ['jenis', 'like', 'Baptis B%']])->get();
        $user = User::all();
        return view('pendaftaranbaptis.index',compact("data", "baptis", "user"));
    }

    public function IndexDewasa()
    {
        $data = DB::table('list_events')
                ->where('jenis_event', 'like', 'Baptis D%')
                ->get();
        $baptis = Baptis::where([['user_id', Auth::user()->id], ['jenis', 'like', 'Baptis D%']])->get();
        $user = User::all();
        return view('pendaftaranbaptis.indexDewasa',compact("data", "baptis", "user"));
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

        return view('pendaftaranbaptis.InputForm',compact("list", "user"));
    }

    public function OpenFormDewasa(Request $request)
    {
        $id = $request->id;
        $list = DB::table('list_events')->where('id', $id)->get();
        $user = DB::table('users')
            ->join('lingkungans', 'users.lingkungan_id', '=', 'lingkungans.id')
            ->join('kbgs', 'users.kbg_id', '=', 'kbgs.id')
            ->where('users.id', Auth::user()->id)
            ->get();

        return view('pendaftaranbaptis.InputForm',compact("list", "user"));
    }

    public function InputForm(Request $request)
    {
        
        // return $request->all();
        if($request->jenis == "Baptis Bayi")
        {
            $data = new Baptis();
            $data->user_id = Auth::user()->id;
            $data->nama_lengkap = $request->get("nama_lengkap");
            $data->tempat_lahir = $request->get("tempat_lahir");
            $data->tanggal_lahir = $request->get("tanggal_lahir");
            $data->orangtua_ayah = $request->get("orangtua_ayah");
            $data->orangtua_ibu = $request->get("orangtua_ibu");
            $data->wali_baptis_ayah = $request->get("wali_baptis_ayah");
            $data->wali_baptis_ibu = $request->get("wali_baptis_ibu");
            $data->lingkungan = $request->get("lingkungan");
            $data->kbg = $request->get("kbg");
            $data->telepon = $request->get("telepon");
            $data->jenis = $request->get("jenis");
            $data->jadwal = $request->get("jadwal");
            $data->lokasi = $request->get("lokasi");
            $data->romo = $request->get("romo");
            $data->status = "Diproses";
            $data->save();

            $riwayat = new Riwayat();
            $riwayat->user_id = Auth::user()->id;
            $riwayat->list_event_id = $request->event_id;
            $riwayat->jenis_event =  $data->jenis;
            $riwayat->event_id =  $data->id;
            $riwayat->status =  "Diproses";
            $riwayat->save();

            return redirect()->route('pendaftaranbaptis.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Baptis Bayi Berhasil');
        }
        else
        {
            $data = new Baptis();
            $data->user_id = Auth::user()->id;
            $data->nama_lengkap = $request->get("nama_lengkap");
            $data->tempat_lahir = $request->get("tempat_lahir");
            $data->tanggal_lahir = $request->get("tanggal_lahir");
            $data->orangtua_ayah = $request->get("orangtua_ayah");
            $data->orangtua_ibu = $request->get("orangtua_ibu");
            $data->wali_baptis_ayah = $request->get("wali_baptis_ayah");
            $data->wali_baptis_ibu = $request->get("wali_baptis_ibu");
            $data->lingkungan = $request->get("lingkungan");
            $data->kbg = $request->get("kbg");
            $data->telepon = $request->get("telepon");
            $data->jenis = $request->get("jenis");
            $data->jadwal = $request->get("jadwal");
            $data->lokasi = $request->get("lokasi");
            $data->romo = $request->get("romo");
            $data->status = "Diproses";

            $file=$request->file('surat_pernyataan');
            $imgFolder = 'file_sertifikat/surat_pernyataan';
            $extension = $request->file('surat_pernyataan')->extension();
            $imgFile=time()."_".$request->get('nama').".".$extension;
            $file->move($imgFolder,$imgFile);
            $data->surat_pernyataan=$imgFile;

            $data->save();

            $riwayat = new Riwayat();
            $riwayat->user_id = Auth::user()->id;
            $riwayat->jenis_event =  $data->jenis;
            $riwayat->event_id =  $data->id;
            $riwayat->status =  "Diproses";
            $riwayat->save();

            return redirect()->route('pendaftaranbaptis.indexDewasa', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Baptis Dewasa Berhasil');
        }
    }

    public function detail(Request $request)
    {
        $id=$request->get("id");
        $log=Riwayat::where([['event_id', '=', $id], ['jenis_event', '=', 'Baptis Bayi']])
        ->get();
        
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('pendaftaranbaptis.detail', compact("log"))->render()),200);
    }

    public function detailDewasa(Request $request)
    {
        $id=$request->get("id");
        $log=Riwayat::where([['event_id', '=', $id], ['jenis_event', '=', 'Baptis Dewasa']])
        ->get();
        
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('pendaftaranbaptis.detail', compact("log"))->render()),200);
    }

    public function Pembatalan(Request $request)
    {
        $data=Baptis::find($request->id);
        if($data->jenis == "Baptis Bayi")
        {
            $data->status = "Dibatalkan";
            $data->save();

            $riwayat = new Riwayat();
            $riwayat->user_id = Auth::user()->id;
            $riwayat->event_id =  $data->id;
            $riwayat->jenis_event =  "Baptis Bayi";
            $riwayat->status =  "Dibatalkan";
            $riwayat->alasan_pembatalan = $request->get("alasan_pembatalan");
            $riwayat->save();

            return redirect()->route('pendaftaranbaptis.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Baptis Bayi Telah Dibatalkan');
        }
        else
        {
            $data->status = "Dibatalkan";
            $data->save();

            $riwayat = new Riwayat();
            $riwayat->user_id = Auth::user()->id;
            $riwayat->event_id =  $data->id;
            $riwayat->jenis_event =  "Baptis Dewasa";
            $riwayat->status =  "Dibatalkan";
            $riwayat->alasan_pembatalan = $request->get("alasan_pembatalan");
            $riwayat->save();

            return redirect()->route('pendaftaranbaptis.indexDewasa', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Baptis Dewasa Telah Dibatalkan');
        }
    }
}
