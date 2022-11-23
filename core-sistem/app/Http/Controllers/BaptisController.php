<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Baptis;
use App\Models\Riwayat;
use App\Models\ListEvent;
use Auth;

class BaptisController extends Controller
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
            $data = ListEvent::where([['jenis_event', 'like', 'Baptis B%'], ['status', 'Aktif']])
            ->orderBy('jadwal_pelaksanaan', 'ASC')
            ->get();
    
            $user = Auth::user()->id;
            $baptis = DB::table('baptiss')
            ->join('riwayats', 'baptiss.id', '=', 'riwayats.event_id')
            ->where([['riwayats.status', 'Disetujui Paroki'], ['riwayats.jenis_event', 'like', 'B%']])
            ->orwhere([['riwayats.status', 'Dibatalkan'], ['riwayats.user_id', $user], ['riwayats.jenis_event', 'like', 'B%']])
            ->orderBy('baptiss.jadwal', 'DESC')
            ->get(['baptiss.*', 'riwayats.id as riwayatID', 'riwayats.status as statusRiwayat', 
            'riwayats.created_at', 'riwayats.updated_at', 'riwayats.alasan_pembatalan']);
    
            return view('baptis.index',compact("data", "baptis"));
        }
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

        return view('baptis.InputForm',compact("list", "user"));
    }

    public function store(Request $request)
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
        $data->status = "Disetujui Paroki";
        $data->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->jenis_event =  $data->jenis;
        $riwayat->event_id =  $data->id;
        $riwayat->status =  "Disetujui Paroki";
        $riwayat->save();

        return redirect()->route('baptis.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Baptis Berhasil Ditambahkan');
    }

    public function EditForm(Request $request)
    {
        $id=$request->get("id");
        $data=Baptis::find($id);
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('baptis.EditForm',compact("data"))->render()),200);
    }

    public function update(Request $request)
    {
        $baptis=Baptis::find($request->id);
        $baptis->user_id = Auth::user()->id;
        $baptis->nama_lengkap = $request->get("nama_lengkap");
        $baptis->tempat_lahir = $request->get("tempat_lahir");
        $baptis->tanggal_lahir = $request->get("tanggal_lahir");
        $baptis->orangtua_ayah = $request->get("orangtua_ayah");
        $baptis->orangtua_ibu = $request->get("orangtua_ibu");
        $baptis->wali_baptis_ayah = $request->get("wali_baptis_ayah");
        $baptis->wali_baptis_ibu = $request->get("wali_baptis_ibu");
        $baptis->lingkungan = $request->get("lingkungan");
        $baptis->kbg = $request->get("kbg");
        $baptis->telepon = $request->get("telepon");
        $baptis->save();
        

        return redirect()->route('baptis.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Data Pendaftaran Baptis Berhasil Diubah');
    }

    public function Pembatalan(Request $request)
    {
        $data=Baptis::find($request->id);
        $data->status = "Dibatalkan";
        $data->save();

        $riwayat = new Riwayat();
        $riwayat->user_id = Auth::user()->id;
        $riwayat->event_id =  $data->id;
        $riwayat->jenis_event =  "Baptis Bayi";
        $riwayat->status =  "Dibatalkan";
        $riwayat->alasan_pembatalan = $request->get("alasan_pembatalan");
        $riwayat->save();

        return redirect()->route('baptis.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Baptis Berhasil Dibatalkan');
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
     * @param  \App\Models\Baptis  $baptis
     * @return \Illuminate\Http\Response
     */
    public function show(Baptis $baptis)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Baptis  $baptis
     * @return \Illuminate\Http\Response
     */
    public function edit(Baptis $baptis)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Baptis  $baptis
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $baptis=Baptis::find($request->id);
        try
        {
            $baptis->delete();
            return redirect()->route('baptiss.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Data Baptis Berhasil Dihapus');
        
        }
        catch(\Exception $e)
        {
            $baptis = "Gagal Menghapus Data Baptis";
            return redirect()->route('baptiss.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error', $msg);    
        }
    }



}
