<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Keluarga;
use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=User::all();
        $kel=Keluarga::all();
        return view('user.index',compact("data", "kel"));
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function redirect(Request $request)
    {
        return view('auth.complete-register');
    }

    public function complete_register(Request $request)
    {
        $id = Auth::user()->id;
        $user=User::find($id);
        $user->nama=$request->get('nama');
        $user->tempat_lahir=$request->get('tempat_lahir');
        $user->tanggal_lahir=$request->get('tanggal_lahir');
        $user->agama=$request->get('agama');
        $user->jenis_kelamin=$request->get('jenis_kelamin');
        $user->telepon=$request->get('telepon');

        $user->save();

        return redirect()->route('kbgs.index', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Daftar User Berhasil');
    
    }
}
