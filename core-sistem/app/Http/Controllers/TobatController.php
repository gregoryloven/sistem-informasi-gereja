<?php

namespace App\Http\Controllers;

use App\Models\Tobat;
use Illuminate\Http\Request;
use DB;

class TobatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Tobat::all();
        return view('tobat.index',compact("data"));
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
        $data = new Tobat();

        $data->jadwal = $request->get('jadwal');
        $data->lokasi = $request->get('lokasi');
        $data->kuota = $request->get('kuota');

        $data->save();

        return redirect()->route('tobats.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Jadwal Tobat Berhasil ditambahkan');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tobat  $tobat
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->id;
        $data = DB::table('tobat_users')->where('tobats_id', $id)->get();
        return view('tobat.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tobat  $tobat
     * @return \Illuminate\Http\Response
     */
    public function edit(Tobat $tobat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tobat  $tobat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $tobat=Tobat::find($request->id);
        $tobat->jadwal = $request->get('jadwal');
        $tobat->lokasi = $request->get('lokasi');
        $tobat->kuota = $request->get('kuota');

        $tobat->save();

        return redirect()->route('tobats.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Jadwal Tobat Berhasil diubah');
    
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tobat  $tobat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $tobat=Tobat::find($request->id);
        try
        {
            $tobat->delete();
            return redirect()->route('tobats.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Jadwal Tobat Berhasil Dihapus');
        }
        catch(\Exception $e)
        {
            return redirect()->route('tobats.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error', "Gagal Menghapus Jadwal Tobat");
        }
    }

    public function EditForm(Request $request)
    {
        $id=$request->get("id");
        $data=Tobat::find($id);
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('tobat.EditForm',compact('data'))->render()),200);
    }
}
