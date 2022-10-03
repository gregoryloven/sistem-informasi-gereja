<?php

namespace App\Http\Controllers;

use App\Models\Umat;
use App\Models\Lingkungan;
use App\Models\Kbg;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class PendaftaranUmatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ling = Lingkungan::all();
        $kbg = Kbg::all();

        return view('pendaftaranumat.index',compact("ling","kbg"));
    }

    public function showKbg($id)
    {
        $kbg = Kbg::where('lingkungan_id', $id)->get();
    }

    public function InputFormLama(Request $request)
    {
        // return $request->all();
        $user = User::find( Auth()->user()->id);
        $user->lingkungan_id = $request->lingkungan_id_lama;
        $user->kbg_id = $request->kbg_id_lama;
        $user->save();

        return redirect('/pendaftaranumat');
    }

    public function InputFormBaru(Request $request)
    {
        return $request->all();
    }

    public function fetchkbg(Request $request)
    {
        $kbg = Kbg::where('lingkungan_id', $request->id)->get();

        // $output = '<option value="">Choose</option>';
        $output = "";
        foreach($kbg as $o) {
            $output .= '<option value="'.$o->id.'">'.$o->nama_kbg.'</option>';
        }
        echo $output;

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Umat  $umat
     * @return \Illuminate\Http\Response
     */
    public function show(Umat $umat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Umat  $umat
     * @return \Illuminate\Http\Response
     */
    public function edit(Umat $umat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Umat  $umat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Umat $umat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Umat  $umat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Umat $umat)
    {
        //
    }
}
