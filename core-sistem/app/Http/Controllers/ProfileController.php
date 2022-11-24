<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tenant;
use Auth;
use Hash;
use DB;

class ProfileController extends Controller
{
    public function data()
    {
        $data = User::where('id', Auth::user()->id)->first();
        // $tenant = Tenant::join('users', 'tenants.nama_paroki', '=', 'users.name')
        // ->where()
        // $tenant = DB::connection('landlord')->table('tenants')->join('us')
        // $user =  DB::connection('tenant')->table('users')->where('id', Auth::user()->id)->first();
// dd($tenant);

        // if(\Spatie\Multitenancy\Models\Tenant::checkCurrent())
        // {
        //     $tenant = DB::connection('landlord')->table('tenants')->where('name', app('currentTenant')->name)->first();
        // }
        $tenant = Tenant::where('name', app('currentTenant')->name)->first();

        if($data->role == "umat")
        {
            return view('profile.profileumat',compact('data'));
        }
        else if($data->role == "ketua kbg")
        {
            return view('profile.profilekbg',compact('data'));
        }
        else if($data->role == "ketua lingkungan")
        {
            return view('profile.profilelingkungan',compact('data'));
        }
        else
        {
            return view('profile.profileadmin',compact('data', 'tenant'));
        }
        
    }

    public function update(Request $request)
    {
        // return $request->all();
        $data = User::find(Auth::user()->id);

        if(\Spatie\Multitenancy\Models\Tenant::checkCurrent())
        {
            $tenant = Tenant::where('name', app('currentTenant')->name)->first();
        }

        // return $data;
        if($data->role == "umat")
        {
            $data->nama_lengkap = $request->get("nama_lengkap");
            $data->tempat_lahir = $request->get("tempat_lahir");
            $data->tanggal_lahir = $request->get("tanggal_lahir");
            $data->agama = $request->get("agama");
            $data->jenis_kelamin = $request->get("jenis_kelamin");
            $data->telepon = $request->get("telepon");
            $data->save();

            return redirect()->back()->with('status', 'Data Akun Berhasil Diubah');
        }
        else if($data->role == "ketua kbg")
        {
            $data->nama_lengkap = $request->get("nama_lengkap");
            $data->telepon = $request->get("telepon");
            $data->save();

            return redirect()->back()->with('status', 'Data Akun Berhasil Diubah');
        }
        else if($data->role == "ketua lingkungan")
        {
            $data->nama_lengkap = $request->get("nama_lengkap");
            $data->telepon = $request->get("telepon");
            $data->save();

            return redirect()->back()->with('status', 'Data Akun Berhasil Diubah');
        }
        else if($data->role == "admin")
        {
            $data->name = $request->get("name");
            $tenant->nama_paroki = $request->get("nama_paroki");
            $tenant->alamat = $request->get("alamat");
            $tenant->telepon = $request->get("telepon");

            $file=$request->file('logo');
            if(isset($file))
            {
                $imgFolder = 'logo';
                $extension = $request->file('logo')->extension();
                $imgfile=time()."_".$request->get('nama').".".$extension;
                $file->move($imgFolder,$imgfile);
                $tenant->logo=$imgfile;
            }

            $data->save();
            $tenant->save();

            return redirect()->back()->with('status', 'Data Akun Berhasil Diubah');
        }
    }
}


