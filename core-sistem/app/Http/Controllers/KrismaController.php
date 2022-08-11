<?php

namespace App\Http\Controllers;

use App\Models\Krisma;
use App\Models\User;
use Illuminate\Http\Request;

class KrismaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Krisma::all();
        $users = User::all();
        return view('krisma.index',compact("data","users"));
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
        $data = new Krisma();
        $data->user_id = $request->get('user_id');
        $data->jadwal = date('Y-m-d', strtotime(str_replace('/', '-',$request->input('jadwal'))));
        $data->lokasi = $request->get('lokasi');
        $data->romo = $request->get('romo');
        $data->status = $request->get('status');

        //File Sertifikat
        $file=$request->file('file_sertifikat');
        $imgFolder = 'file_sertifikat/krisma';
        $extension = $request->file('file_sertifikat')->extension();
        $imgFile=time()."_".$request->get('nama').".".$extension;
        $file->move($imgFolder,$imgFile);
        $data->file_sertifikat=$imgFile;
        
        $data->save();

        return redirect()->route('krismas.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Data Krisma Berhasil ditambahkan');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Krisma  $krisma
     * @return \Illuminate\Http\Response
     */
    public function show(Krisma $krisma)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Krisma  $krisma
     * @return \Illuminate\Http\Response
     */
    public function edit(Krisma $krisma)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Krisma  $krisma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $krisma=Krisma::find($request->id);
        $krisma->user_id = $request->get('user_id');
        $krisma->jadwal = $request->get('jadwal');
        $krisma->lokasi = $request->get('lokasi');
        $krisma->romo = $request->get('romo');
        $krisma->status = $request->get('status');

        //File Sertifikat
        $file=$request->file('file_sertifikat');
        $imgFolder = 'file_sertifikat/krisma';
        $extension = $request->file('file_sertifikat')->extension();
        $imgFile=time()."_".$request->get('nama').".".$extension;
        $file->move($imgFolder,$imgFile);
        $krisma->file_sertifikat=$imgFile;
        
        $krisma->save();

        return redirect()->route('krismas.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Data Krisma Berhasil ditambahkan');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Krisma  $krisma
     * @return \Illuminate\Http\Response
     */
    public function destroy(Krisma $krisma)
    {
        $krisma=Krisma::find($request->id);
        try
        {
            $krisma->delete();
            return redirect()->route('krismas.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Data Krisma Berhasil Dihapus');
        
        }
        catch(\Exception $e)
        {
            $krisma = "Gagal Menghapus Data Krisma";
            return redirect()->route('krismas.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('error', $msg);    
        }
    }

    public function EditForm(Request $request)
    {
        $id=$request->get("id");
        $data=Krisma::find($id);
        $users=User::all();
        return response()->json(array(
            'status'=>'oke',
            'msg'=>view('krisma.EditForm',compact("data","users"))->render()),200);
    }
}
