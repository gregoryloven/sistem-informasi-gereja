<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KomuniPertama;
use App\Models\User;

class KomuniPertamaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = KomuniPertama::all();
        $users = User::all();
        return view('komunipertama.index',compact("data","users"));
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
        $data = new KomuniPertama();
        $data->user_id = $request->get('user_id');
        $data->jadwal = date('Y-m-d', strtotime(str_replace('/', '-',$request->input('jadwal'))));
        $data->lokasi = $request->get('lokasi');
        $data->romo = $request->get('romo');
        $data->status = $request->get('status');

        //File Sertifikat
        $file=$request->file('file_sertifikat');
        $imgFolder = 'file_sertifikat/komunipertama';
        $extension = $request->file('file_sertifikat')->extension();
        $imgFile=time()."_".$request->get('nama').".".$extension;
        $file->move($imgFolder,$imgFile);
        $data->file_sertifikat=$imgFile;
        
        $data->save();

        return redirect()->route('komunipertamas.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Data Komuni Pertama Berhasil ditambahkan');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KomuniPertama  $komuniPertama
     * @return \Illuminate\Http\Response
     */
    public function show(KomuniPertama $komuniPertama)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KomuniPertama  $komuniPertama
     * @return \Illuminate\Http\Response
     */
    public function edit(KomuniPertama $komuniPertama)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KomuniPertama  $komuniPertama
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $komunipertama=KomuniPertama::find($request->id);
        $komunipertama->user_id = $request->get('user_id');
        $komunipertama->jadwal = $request->get('jadwal');
        $komunipertama->lokasi = $request->get('lokasi');
        $komunipertama->romo = $request->get('romo');
        $komunipertama->status = $request->get('status');

        //File Sertifikat
        $file=$request->file('file_sertifikat');
        $imgFolder = 'file_sertifikat/komunipertama';
        $extension = $request->file('file_sertifikat')->extension();
        $imgFile=time()."_".$request->get('nama').".".$extension;
        $file->move($imgFolder,$imgFile);
        $komunipertama->file_sertifikat=$imgFile;
        
        $komunipertama->save();

        return redirect()->route('komunipertamas.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Data Komuni Pertama Berhasil ditambahkan');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KomuniPertama  $komuniPertama
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $komunipertama=KomuniPertama::find($request->id);
        try
        {
            $komunipertama->delete();
            return redirect()->route('komunipertamas.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Data Komuni Pertama Berhasil Dihapus');
        
        }
        catch(\Exception $e)
        {
            $komunipertama = "Gagal Menghapus Data Komuni Pertama";
            return redirect()->route('komunipertamas.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error', $msg);    
        }
    }

    public function EditForm(Request $request)
    {
        $id=$request->get("id");
        $data=KomuniPertama::find($id);
        $users=User::all();
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('komunipertama.EditForm',compact("data","users"))->render()),200);
    }
}
