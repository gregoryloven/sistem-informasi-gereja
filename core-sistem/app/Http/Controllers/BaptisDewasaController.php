<?php

namespace App\Http\Controllers;

use App\Models\Baptis;
use App\Models\ListEvent;
use App\Models\Kbg;
use App\Models\Lingkungan;
use Illuminate\Http\Request;
use DB;
use Auth;

class BaptisDewasaController extends Controller
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
            $data = ListEvent::where([['jenis_event', 'like', 'Baptis D%'], ['status', 'Aktif']])
            ->orderBy('jadwal_pelaksanaan', 'ASC')
            ->get();

            $baptis = Baptis::where([['jenis', 'like', 'Baptis D%'], ['status', 'Disetujui Paroki'], ['user_id', Auth::user()->id]])
            ->orderby('jadwal', 'ASC')
            ->get();
    
            return view('baptisdewasa.index',compact("data", "baptis"));
        }
    }

    public function OpenForm(Request $request)
    {
        $id = $request->id;
        $list = ListEvent::where('id', $id)->get();
        $kbg = Kbg::all();
        $ling = Lingkungan::all();

        return view('baptisdewasa.InputForm',compact("list", "kbg", "ling"));
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

        $file=$request->file('surat_pernyataan');
        $imgFolder = 'file_sertifikat/surat_pernyataan';
        $extension = $request->file('surat_pernyataan')->extension();
        $imgFile=time()."_".$request->get('nama').".".$extension;
        $file->move($imgFolder,$imgFile);
        $data->surat_pernyataan=$imgFile;
        
        $data->save();

        return redirect()->route('baptisdewasa.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Baptis Dewasa Berhasil');
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Baptis  $baptis
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Baptis $baptis)
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
            return redirect()->route('baptisdewasa.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Pendaftaran Baptis Dewasa Berhasil Dihapus');
        
        }
        catch(\Exception $e)
        {
            $baptis = "Gagal Menghapus Data Baptis Dewasa";
            return redirect()->route('baptisdewasa.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error', $msg);    
        }
    }
}
