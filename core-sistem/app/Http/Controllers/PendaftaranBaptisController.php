<?php

namespace App\Http\Controllers;

use App\Models\ListEvent;
use App\Models\Baptis;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                ->where('jenis_event', 'like', 'B%')
                ->get();
        $baptis = Baptis::all();
        $users = User::all();
        $wali_baptis_ayah = User::where([['jenis_kelamin', 'Pria']])->get();
        $wali_baptis_ibu = User::where([['jenis_kelamin', 'Wanita']])->get();
        return view('pendaftaranbaptis.index',compact("data", "baptis", "users", "wali_baptis_ayah", "wali_baptis_ibu"));
    }

    public function OpenForm(Request $request)
    {
        $id = $request->id;
        $list = DB::table('list_events')->where('id', $id)->get();
        // dd($list);

        $users = User::all();
        $wali_baptis_ayah = User::where([['jenis_kelamin', 'Pria']])->get();
        $wali_baptis_ibu = User::where([['jenis_kelamin', 'Wanita']])->get();

        return view('pendaftaranbaptis.InputForm',compact("list", "users", "wali_baptis_ayah", "wali_baptis_ibu"));
    }

    public function InputForm(Request $request)
    {
        $data = new Baptis();
        $data->user_id = $request->get("nama_user");
        $data->wali_baptis_ayah = $request->get("wali_baptis_ayah");
        $data->wali_baptis_ibu = $request->get("wali_baptis_ibu");
        $data->jenis = $request->get("jenis");
        $data->jadwal = $request->get("jadwal");
        $data->lokasi = $request->get("lokasi");
        $data->romo = $request->get("romo");
        $data->status = "Diproses";
        $data->save();

        return redirect()->route('pendaftaranbaptis.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Baptis Berhasil');

    }

    public function Pembatalan(Request $request)
    {
        $data=Baptis::find($request->id);
        $data->status = "Dibatalkan";
        $data->alasan_pembatalan = $request->get("alasan_pembatalan");

        $data->save();

        return redirect()->route('pendaftaranbaptis.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Permohonan Pelayanan Berhasil Dibatalkan');
    }
}
