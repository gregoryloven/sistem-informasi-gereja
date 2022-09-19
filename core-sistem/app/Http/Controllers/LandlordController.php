<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Tenant;
use Carbon\Carbon;
use Artisan;
use Auth;

class LandlordController extends Controller
{

    public function index()
    {
        return view('landlord.index');
    }

    public function dashboards()
    {
        return view('landlord.dashboards');
    }

    public function tenant()
    {
        $data = Tenant::with('user')->get();
        return view('landlord.tenant', compact("data"));
    }

    public function deletetenant(Request $request)
    {
        try {
            $data = Tenant::find($request->tenant_id);
            $dbname = strtolower($data->database);
            DB::Connection()->statement("DROP DATABASE $dbname");
            $data->delete();
            return redirect('/dashboards/tenant')->with('status', 'Data Tenant Berhasil Dihapus');
        } catch (\Throwable $th) {
            return redirect('/dashboards/tenant')->with('error', 'Tidak Dapat Menghapus Data Tenant');
        }

    }

    public function user()
    {
        $data = User::where('role', 'tenant')->get();
        return view('landlord.user', compact("data"));
    }

    public function deleteuser(Request $request)
    {
        try {
            $data = User::find($request->user_id);
            $tenant = Tenant::where('user_id', $data->id)->get();
            $data->delete();
            foreach ($tenant as $t) {
                $t->delete();
            }
            return redirect('/dashboards/user')->with('status', 'Data User Berhasil Dihapus');
        } catch (\Throwable $th) {
            return redirect('/dashboards/user')->with('error', 'Tidak Dapat Menghapus Data User');
        }
    }
    
    //REGISTRASI AKUN PIHAK GEREJA
    // public function redirect_landlord()
    // {
    //     return view('auth.complete-register-landlord');
    // }

    // public function complete_register_landlord(Request $request)
    // {
    //     $id = Auth::user()->id;
    //     $user=User::find($id);
    //     $user->nama_lengkap=$request->get('nama_lengkap');
    //     $user->tempat_lahir=$request->get('tempat_lahir');
    //     $user->tanggal_lahir=$request->get('tanggal_lahir');
    //     $user->agama=$request->get('agama');
    //     $user->jenis_kelamin=$request->get('jenis_kelamin');
    //     $user->telepon=$request->get('telepon');

    //     $user->save();

    //     return redirect('/')->with('status', 'Daftar User Berhasil');
    // }
    

    //PENDAFTARAN WEBSITE PIHAK GEREJA
    public function daftargereja()
    {
        $id = Auth::user()->id;
        $cekTenant = Tenant::where('user_id', $id)->first();
        $role = Auth::user()->role;
        return view('landlord.pendaftarangereja', compact('cekTenant', 'role'));
    }

    public function simpandaftargereja(Request $request)
    {
        try {
            // return $request->all();

            $tenant = new Tenant;
            $tenant->name       = $request->nama_paroki;
            $tenant->nama_paroki= $request->nama_paroki;
            $tenant->telepon    = $request->nomor_telepon;
            $tenant->alamat     = $request->alamat;
            $tenant->domain     = strtolower(preg_replace('/[^A-Za-z0-9]/', '', str_replace(' ', '', $request->domain))).".localhost";
            $tenant->database   = strtolower(preg_replace('/[^A-Za-z0-9]/', '', str_replace(' ', '', $request->domain)));
            $tenant->user_id    = Auth::user()->id;
            $tenant->save();

            $newTenant = Tenant::where('database', strtolower(preg_replace('/[^A-Za-z0-9]/', '', str_replace(' ', '', $request->domain))))->first();
            $dbname = strtolower(preg_replace('/[^A-Za-z0-9]/', '', str_replace(' ', '', $request->domain)));
            
            // return $newTenant->id;

            DB::Connection()->statement("CREATE DATABASE $dbname");
            Artisan::call('tenants:artisan migrate --tenant='.$newTenant->id);

            DB::table($newTenant->database.'.users')->insert([
                'name'          => Auth::user()->name,
                'email'         => Auth::user()->email,
                'password'      => Auth::user()->password,
                'role'          => 'admin',
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at'    => Carbon::now()->format('Y-m-d H:i:s')
            ]);
            return redirect('daftargereja');
        } catch (\Throwable $th) {
            return redirect('daftargereja')->with('error', 'Nama Database atau Domain sudah terpakai. Silahkan gunakan nama yang lain.');
        }
    }

}