<?php

namespace App\Http\Controllers;

use App\Models\Kbg;
use App\Models\Lingkungan;
use Illuminate\Http\Request;
use Auth;

class KbgController extends Controller
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
            $data=Kbg::all();
            $ling=Lingkungan::all();
            return view('kbg.index',compact("data", "ling"));
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
        $data = new Kbg();
        $data->lingkungan_id = $request->get('lingkungan_id');
        $data->nama_kbg = $request->get('nama_kbg');
        $data->batasan_wilayah = $request->get('batasan_wilayah');
        
        $data->save();

        return redirect()->route('kbgs.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Data KBG Berhasil ditambahkan');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kbg  $kbg
     * @return \Illuminate\Http\Response
     */
    public function show(Kbg $kbg)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kbg  $kbg
     * @return \Illuminate\Http\Response
     */
    public function edit(Kbg $kbg)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kbg  $kbg
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $kbg=Kbg::find($request->id);
        $kbg->lingkungan_id=$request->get('lingkungan_id');
        $kbg->nama_kbg=$request->get('nama_kbg');
        $kbg->batasan_wilayah=$request->get('batasan_wilayah');

        $kbg->save();

        return redirect()->route('kbgs.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'KBG Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kbg  $kbg
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $kbg=Kbg::find($request->id);
        try
        {
            $kbg->delete();
            return redirect()->route('kbgs.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'KBG Berhasil Dihapus');
        
        }
        catch(\Exception $e)
        {
            $msg = "Gagal menghapus data KBG";
            return redirect()->route('kbgs.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error', $msg);    
        }
    }

    public function EditForm(Request $request)
    {
        $id=$request->get("id");
        $data=Kbg::find($id);
        $ling=Lingkungan::all();
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('kbg.EditForm',compact('data','ling'))->render()),200);
    }
}
