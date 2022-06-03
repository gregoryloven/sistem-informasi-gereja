<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paroki;

class ParokiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ("paroki.index",["data"=>Paroki::all()]);
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
        $data = new Paroki();

        $data->nama_paroki = $request->get('nama_paroki');
        $data->alamat = $request->get('alamat');
        $data->email = $request->get('email');
        $data->telepon = $request->get('telepon');

        $data->save();

        return redirect()->route('parokis.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Paroki Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $paroki=Paroki::find($request->id);
        $paroki->nama_paroki=$request->get('nama_paroki');
        $paroki->alamat=$request->get('alamat');
        $paroki->email=$request->get('email');
        $paroki->telepon=$request->get('telepon');

        $paroki->save();
        
        return redirect()->route('parokis.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Paroki Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $paroki=Paroki::find($request->id);
        try
        {
            $paroki->delete();
            return redirect()->route('parokis.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Paroki Berhasil Dihapus');
        }
        catch(\Exception $e)
        {
            return redirect()->route('parokis.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error', "Gagal menghapus data paroki");
        }
    }

    public function EditForm(Request $request)
    {
        $id=$request->get("id");
        $data=Paroki::find($id);
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('paroki.EditForm',compact('data'))->render()),200);
    }
}
