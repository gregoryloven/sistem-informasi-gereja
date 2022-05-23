<?php

namespace App\Http\Controllers;

use App\Models\Misa;
use DB;
use Illuminate\Http\Request;

class MisaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Misa::all();
        return view('misa.index',compact("data"));
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
        $data = new Misa();

        $data->jenis = $request->get('jenis');
        $data->jadwal = $request->get('jadwal');
        $data->lokasi = $request->get('lokasi');
        $data->kuota = $request->get('kuota');

        $data->save();

        return redirect()->route('misas.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Jadwal Misa Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Misa  $misa
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->id;
        $data = DB::table('misa_users')->where('misas_id', $id)->get();
        return view('misa.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Misa  $misa
     * @return \Illuminate\Http\Response
     */
    public function edit(Misa $misa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Misa  $misa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $misa=Misa::find($request->id);
        $misa->jenis = $request->get('jenis');
        $misa->jadwal = $request->get('jadwal');
        $misa->lokasi = $request->get('lokasi');
        $misa->kuota = $request->get('kuota');

        $misa->save();

        return redirect()->route('misas.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Jadwal Misa Berhasil diubah');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Misa  $misa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $misa=Misa::find($request->id);
        try
        {
            $misa->delete();
            return redirect()->route('misas.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Jadwal Misa Berhasil Dihapus');
        }
        catch(\Exception $e)
        {
            return redirect()->route('misas.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error', "Gagal Menghapus Jadwal Misa");
        }
    }

    public function EditForm(Request $request)
    {
        $id=$request->get("id");
        $data=Misa::find($id);
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('misa.EditForm',compact('data'))->render()),200);
    }

    public function reservasi(Request $request)
    {
        $data=Misa::all();
        return view('misa.reservasi',compact("data"));
    }

    public function BookMisa(Request $request)
    {
        $id=$request->get("id");
        $data=Misa::find($id);
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('misa.BookMisa',compact('data'))->render()),200);
    }
}
