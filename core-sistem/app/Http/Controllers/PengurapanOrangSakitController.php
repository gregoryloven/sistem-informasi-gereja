<?php

namespace App\Http\Controllers;

use App\Models\PengurapanOrangSakit;
use Illuminate\Http\Request;
use DB;

class PengurapanOrangSakitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=PengurapanOrangSakit::all();
        return view('pengurapansakit.index',compact("data"));
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
        $data = new PengurapanOrangSakit();

        $data->jadwal = $request->get('jadwal');
        $data->lokasi = $request->get('lokasi');
        $data->keterangan = $request->get('keterangan');

        $data->save();

        return redirect()->route('pengurapansakits.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Jadwal Pengurapan Orang Sakit Berhasil ditambahkan');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PengurapanOrangSakit  $pengurapanOrangSakit
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->id;
        $data = DB::table('pengurapan_orang_sakit_users')->where('pengurapan_orang_sakit_id', $id)->get();
        return view('pengurapansakit.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PengurapanOrangSakit  $pengurapanOrangSakit
     * @return \Illuminate\Http\Response
     */
    public function edit(PengurapanOrangSakit $pengurapanOrangSakit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PengurapanOrangSakit  $pengurapanOrangSakit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $pengurapan=PengurapanOrangSakit::find($request->id);
        $pengurapan->jadwal = $request->get('jadwal');
        $pengurapan->lokasi = $request->get('lokasi');
        $pengurapan->keterangan = $request->get('keterangan');

        $pengurapan->save();

        return redirect()->route('pengurapansakits.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Jadwal Pengurapan Orang Sakit Berhasil diubah');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PengurapanOrangSakit  $pengurapanOrangSakit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $pengurapan=PengurapanOrangSakit::find($request->id);
        try
        {
            $pengurapan->delete();
            return redirect()->route('pengurapansakits.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Jadwal Pengurapan Orang Sakit Berhasil Dihapus');
        }
        catch(\Exception $e)
        {
            return redirect()->route('pengurapansakits.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error', "Gagal Menghapus Jadwal Pengurapan Orang Sakit");
        }
    }

    public function EditForm(Request $request)
    {
        $id=$request->get("id");
        $data=PengurapanOrangSakit::find($id);
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('pengurapansakit.EditForm',compact('data'))->render()),200);
    }
}
