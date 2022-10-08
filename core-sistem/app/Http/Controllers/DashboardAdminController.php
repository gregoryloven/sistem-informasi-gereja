<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Umat;
use App\Models\Kbg;
use App\Models\Lingkungan;

use App\Models\Baptis;
use App\Models\Krisma;
use App\Models\PendaftaranPelayananLainnya;
use App\Models\PendaftaranPetugas;
use App\Models\KomuniPertama;



class DashboardAdminController extends Controller
{
    public function index()
    {
        $jumlah_umat = Umat::count();
        $jumlah_umat_pria = Umat::where('jenis_kelamin', 'Laki-Laki')->count();
        $jumlah_umat_wanita = Umat::where('jenis_kelamin', 'Perempuan')->count();
        $jumlah_kepala_keluarga = Umat::where('hubungan', 'Kk')->count();
        $jumlah_kbg = Kbg::count();
        $jumlah_lingkungan = Lingkungan::count();

        $jumlah_baptis_bayi = Baptis::where([['jenis', 'Baptis Bayi'], ['status', 'Disetujui Lingkungan']])->count();
        $jumlah_baptis_dewasa = Baptis::where([['jenis', 'Baptis Dewasa'], ['status', 'Disetujui Lingkungan']])->count();
        $jumlah_krisma = Krisma::where('status', 'Disetujui Lingkungan')->count();
        $jumlah_komuni_pertama = KomuniPertama::where('status', 'Disetujui Lingkungan')->count();
        $jumlah_pelayanan_lainnya = PendaftaranPelayananLainnya::where('status', 'Disetujui Lingkungan')->count();
        $jumlah_petugas = PendaftaranPetugas::where('status', 'Diproses')->count();
        
        return view('dashboardadmin.index', compact('jumlah_umat', 'jumlah_umat_pria', 'jumlah_umat_wanita', 'jumlah_kepala_keluarga', 'jumlah_kbg', 'jumlah_lingkungan', 'jumlah_baptis_bayi', 'jumlah_baptis_dewasa', 'jumlah_krisma', 'jumlah_komuni_pertama', 'jumlah_pelayanan_lainnya', 'jumlah_petugas'));
    }

    public function indexkbg()
    {
        $jumlah_umat = Umat::count();
        $jumlah_umat_pria = Umat::where('jenis_kelamin', 'Laki-Laki')->count();
        $jumlah_umat_wanita = Umat::where('jenis_kelamin', 'Perempuan')->count();
        $jumlah_kepala_keluarga = Umat::where('hubungan', 'Kk')->count();
        $jumlah_kbg = Kbg::count();
        $jumlah_lingkungan = Lingkungan::count();

        $jumlah_baptis_bayi = Baptis::where([['jenis', 'Baptis Bayi'], ['status', 'Disetujui Lingkungan']])->count();
        $jumlah_baptis_dewasa = Baptis::where([['jenis', 'Baptis Dewasa'], ['status', 'Disetujui Lingkungan']])->count();
        $jumlah_krisma = Krisma::where('status', 'Diproses')->count();
        $jumlah_komuni_pertama = KomuniPertama::where('status', 'Diproses')->count();
        $jumlah_pelayanan_lainnya = PendaftaranPelayananLainnya::where('status', 'Diproses')->count();

        $pendaftaran_umat_baru = Umat::where('status', 'Diproses')->count();
        
        return view('dashboardadmin.indexkbg', compact('jumlah_umat', 'jumlah_umat_pria', 'jumlah_umat_wanita', 'jumlah_kepala_keluarga', 'jumlah_kbg', 'jumlah_lingkungan', 'jumlah_baptis_bayi', 'jumlah_baptis_dewasa', 'jumlah_krisma', 'jumlah_komuni_pertama', 'jumlah_pelayanan_lainnya', 'pendaftaran_umat_baru'));
    }

    public function indexlingkungan()
    {

        $jumlah_umat = Umat::count();
        $jumlah_umat_pria = Umat::where('jenis_kelamin', 'Laki-Laki')->count();
        $jumlah_umat_wanita = Umat::where('jenis_kelamin', 'Perempuan')->count();
        $jumlah_kepala_keluarga = Umat::where('hubungan', 'Kk')->count();
        $jumlah_kbg = Kbg::count();
        $jumlah_lingkungan = Lingkungan::count();

        $jumlah_baptis_bayi = Baptis::where([['jenis', 'Baptis Bayi'], ['status', 'Disetujui Lingkungan']])->count();
        $jumlah_baptis_dewasa = Baptis::where([['jenis', 'Baptis Dewasa'], ['status', 'Disetujui Lingkungan']])->count();
        $jumlah_krisma = Krisma::where('status', 'Disetujui KBG')->count();
        $jumlah_komuni_pertama = KomuniPertama::where('status', 'Disetujui KBG')->count();
        $jumlah_pelayanan_lainnya = PendaftaranPelayananLainnya::where('status', 'Disetujui KBG')->count();

        $pendaftaran_umat_lama = Umat::where('status', 'Diproses')->count();
        $pendaftaran_umat_baru = Umat::where('status', 'Disetujui KBG')->count();


        
        return view('dashboardadmin.indexlingkungan', compact('jumlah_umat', 'jumlah_umat_pria', 'jumlah_umat_wanita', 'jumlah_kepala_keluarga', 'jumlah_kbg', 'jumlah_lingkungan', 'jumlah_baptis_bayi', 'jumlah_baptis_dewasa', 'jumlah_krisma', 'jumlah_komuni_pertama', 'jumlah_pelayanan_lainnya', 'pendaftaran_umat_lama', 'pendaftaran_umat_baru'));
    }
}
