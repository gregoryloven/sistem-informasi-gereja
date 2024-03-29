<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lingkungan;
use Auth;

class LingkunganController extends Controller
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
            $data=Lingkungan::all();
            return view('lingkungan.index',compact("data"));
        }
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
        $data = new Lingkungan();
        $data->nama_lingkungan = $request->get('nama_lingkungan');
        $data->batasan_wilayah = $request->get('batasan_wilayah');
        
        $data->save();

        return redirect()->route('lingkungans.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Lingkungan Berhasil ditambahkan');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lingkungan  $lingkungan
     * @return \Illuminate\Http\Response
     */
    public function show(Lingkungan $lingkungan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lingkungan  $lingkungan
     * @return \Illuminate\Http\Response
     */
    public function edit(Lingkungan $lingkungan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lingkungan  $lingkungan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $lingkungan=Lingkungan::find($request->id);
        $lingkungan->nama_lingkungan=$request->get('nama_lingkungan');
        $lingkungan->batasan_wilayah=$request->get('batasan_wilayah');

        $lingkungan->save();

        return redirect()->route('lingkungans.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Lingkungan Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lingkungan  $lingkungan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $lingkungan=Lingkungan::find($request->id);
        $lingkungan->delete();
        return redirect()->route('lingkungans.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Lingkungan Berhasil Dihapus');    
        // try
        // {
        //     $lingkungan->delete();
        //     return redirect()->route('lingkungans.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Lingkungan Berhasil Dihapus');    
        // }
        // catch(\Exception $e)
        // {
        //     $msg = "Gagal Menghapus Lingkungan";
        //     return redirect()->route('lingkungans.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error', $msg);    
        // }
    }

    public function EditForm(Request $request)
    {
        $id=$request->get("id");
        $data=Lingkungan::find($id);
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('lingkungan.EditForm',compact('data'))->render()),200);
    }
}
