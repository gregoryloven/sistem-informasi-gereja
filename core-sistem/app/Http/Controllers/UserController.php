<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lingkungan;
use App\Models\Kbg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $id_ketua_lingkungan = DB::table('lingkungans')
        //     ->join('keluargas', 'users.keluarga_id', '=', 'keluargas.id')
        //     ->where('keluargas.id', '=', Auth::id)
        //     ->select('lingkungans.*')
        //     ->get();
            // dd(Auth);
        // $users = DB::table('users')
        //     ->join('keluargas', 'users.keluarga_id', '=', 'keluargas.id')
        //     ->join('lingkungans', 'lingkungans.id', '=', 'keluargas.lingkungan_id')
        //     ->select('users.*', 'keluargas.*', 'lingkungans.*')
        //     ->get();

        // return view('user.index',compact("users"));
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
        $user->nama_lengkap=$request->get('nama_lengkap');
        $user->tempat_lahir=$request->get('tempat_lahir');
        $user->tanggal_lahir=$request->get('tanggal_lahir');
        $user->agama=$request->get('agama');
        $user->jenis_kelamin=$request->get('jenis_kelamin');
        $user->telepon=$request->get('telepon');

        $user->save();

        return redirect('/sbadmin2')->with('status', 'Daftar User Berhasil');
    }

    public function DaftarKL()
    {
        $users = User::where([['role', 'ketua lingkungan']])->get();
        $ling = Lingkungan::all();

        return view('user.kl',compact("users", "ling"));
    }

    public function TambahKL(Request $request)
    {
        $data = new User();
        $data->email = $request->get('email');
        $data->password = Hash::make($request->password);
        $data->lingkungan_id = $request->get('lingkungan_id');
        $data->role = "ketua lingkungan";
        $data->save();
        
        return redirect()->route('user.kl', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Tambah Akun Berhasil');
    }

    public function DaftarKKBG()
    {
        $users = User::where([['role', 'ketua kbg']])->get();
        $kbg = Kbg::all();

        return view('user.kkbg',compact("users", "kbg"));
    }

    public function TambahKKBG(Request $request)
    {
        $data = new User();
        $data->email = $request->get('email');
        $data->password = Hash::make($request->password);
        $data->kbg_id = $request->get('kbg_id');
        $data->role = "ketua kbg";
        $data->save();
        
        return redirect()->route('user.kkbg', substr(app('currentTenant')->domain, 0, strpos(app('currentTenant')->domain, ".localhost")) )->with('status', 'Tambah Akun Berhasil');
    }
}
