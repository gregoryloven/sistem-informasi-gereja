<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Umat;
use App\Models\Kbg;
use App\Models\Lingkungan;
use App\Models\Baptis;
use App\Models\Krisma;
use App\Models\PendaftaranPelayananLainnya;
use App\Models\PendaftaranPetugas;
use App\Models\KomuniPertama;
use App\Models\Kpp;
use App\Models\Perkawinan;
use App\Models\PengurapanOrangSakit;
use Auth;


class DashboardAdminController extends Controller
{
    public function index()
    {
        if(Auth::user()->role != 'admin')
        {
            return back();
        }
        else
        {
            $jumlah_umat = Umat::where('status', 'Disetujui Lingkungan')->count();
            $jumlah_umat_pria = Umat::where([['jenis_kelamin', 'Laki-Laki'], ['status', 'Disetujui Lingkungan']])->count();
            $jumlah_umat_wanita = Umat::where([['jenis_kelamin', 'Perempuan'], ['status', 'Disetujui Lingkungan']])->count();
            $jumlah_kepala_keluarga = Umat::where([['hubungan', 'Kepala Keluarga'], ['status', 'Disetujui Lingkungan']])->count();
            $jumlah_kbg = Kbg::count();
            $jumlah_lingkungan = Lingkungan::count();
    
            $jumlah_baptis_bayi = Baptis::where([['jenis', 'Baptis Bayi'], ['status', 'Disetujui Lingkungan']])->count();
            $jumlah_baptis_dewasa = Baptis::where([['jenis', 'Baptis Dewasa'], ['status', 'Disetujui Lingkungan']])->count();
            $jumlah_komuni_pertama = KomuniPertama::where('status', 'Disetujui Lingkungan')->count();
            $jumlah_krisma = Krisma::where('status', 'Disetujui Lingkungan')->count();
            $jumlah_krisma_lintas = Krisma::where([['status', 'Diproses'],['jenis', 'Lintas Paroki']])->count();
            $jumlah_kpp = Kpp::where('status', 'Disetujui Lingkungan')->count();
            $jumlah_perkawinan = Perkawinan::where('status', 'Disetujui Lingkungan')->count();
            $jumlah_pelayanan_lainnya = PendaftaranPelayananLainnya::where('status', 'Disetujui Lingkungan')->count();
            $jumlah_pengurapan = PengurapanOrangSakit::where('status', 'Disetujui Lingkungan')->count();
            $jumlah_petugas = PendaftaranPetugas::where('status', 'Diproses')->count();
            
            return view('dashboardadmin.index', compact('jumlah_umat', 'jumlah_umat_pria', 'jumlah_umat_wanita', 'jumlah_kepala_keluarga', 'jumlah_kbg', 'jumlah_lingkungan', 'jumlah_baptis_bayi', 'jumlah_baptis_dewasa', 'jumlah_krisma', 'jumlah_krisma_lintas', 'jumlah_komuni_pertama', 'jumlah_pelayanan_lainnya', 'jumlah_petugas', 'jumlah_kpp', 'jumlah_perkawinan', 'jumlah_pengurapan'));
        }
    }

    public function indexkbg()
    {
        if(Auth::user()->role != 'ketua kbg')
        {
            return back();
        }
        else
        {
            $kbg = Auth::user()->kbg->id;
            $kbg2 = Auth::user()->kbg->nama_kbg;

            $jumlah_umat = Umat::where([['kbg_id', $kbg], ['status', 'Disetujui Lingkungan']])->count();
            $jumlah_umat_pria = Umat::where([['kbg_id', $kbg], ['jenis_kelamin', 'Laki-Laki'], ['status', 'Disetujui Lingkungan']])->count();
            $jumlah_umat_wanita = Umat::where([['kbg_id', $kbg], ['jenis_kelamin', 'Perempuan'], ['status', 'Disetujui Lingkungan']])->count();
            $jumlah_kepala_keluarga = Umat::where([['kbg_id', $kbg], ['hubungan', 'Kepala Keluarga'], ['status', 'Disetujui Lingkungan']])->count();
    
            $jumlah_baptis_bayi = Baptis::where([['jenis', 'Baptis Bayi'], ['kbg', $kbg2], ['status', 'Diproses']])->count();
            $jumlah_baptis_dewasa = Baptis::where([['jenis', 'Baptis Dewasa'], ['kbg', $kbg2], ['status', 'Diproses']])->count();
            $jumlah_komuni_pertama = KomuniPertama::where([['status', 'Diproses'], ['kbg', $kbg2]])->count();
            $jumlah_krisma = Krisma::where([['jenis', 'Paroki Setempat'], ['status', 'Diproses'], ['kbg', $kbg2]])->count();
            $jumlah_pelayanan_lainnya = PendaftaranPelayananLainnya::where([['status', 'Diproses'], ['kbg', $kbg2]])->count();
            $jumlah_pengurapan = PengurapanOrangSakit::where([['status', 'Diproses'], ['kbg', $kbg2]])->count();
    
            $pendaftaran_umat_baru = Umat::where([['status', 'Diproses'], ['kbg_id', $kbg]])->count();
            
            return view('dashboardadmin.indexkbg', compact('jumlah_umat', 'jumlah_umat_pria', 'jumlah_umat_wanita', 'jumlah_kepala_keluarga', 'jumlah_baptis_bayi', 'jumlah_baptis_dewasa', 'jumlah_krisma', 'jumlah_komuni_pertama', 'jumlah_pelayanan_lainnya', 'pendaftaran_umat_baru', 'jumlah_pengurapan'));
        }
    }

    public function indexlingkungan()
    {
        if(Auth::user()->role != 'ketua lingkungan')
        {
            return back();
        }
        else
        {
            $ling = Auth::user()->lingkungan->id;
            $ling2 = Auth::user()->lingkungan->nama_lingkungan;

            $jumlah_umat = Umat::where([['lingkungan_id', $ling], ['status', 'Disetujui Lingkungan']])->count();
            $jumlah_umat_pria = Umat::where([['lingkungan_id', $ling], ['jenis_kelamin', 'Laki-Laki'], ['status', 'Disetujui Lingkungan']])->count();
            $jumlah_umat_wanita = Umat::where([['lingkungan_id', $ling], ['jenis_kelamin', 'Perempuan'], ['status', 'Disetujui Lingkungan']])->count();
            $jumlah_kepala_keluarga = Umat::where([['lingkungan_id', $ling], ['hubungan', 'Kepala Keluarga'], ['status', 'Disetujui Lingkungan']])->count();
            $jumlah_kbg = Kbg::where('lingkungan_id', $ling)->count();
    
            $jumlah_baptis_bayi = Baptis::where([['jenis', 'Baptis Bayi'], ['lingkungan', $ling2], ['status', 'Disetujui KBG']])->count();
            $jumlah_baptis_dewasa = Baptis::where([['jenis', 'Baptis Dewasa'], ['lingkungan', $ling2], ['status', 'Disetujui KBG']])->count();
            $jumlah_komuni_pertama = KomuniPertama::where([['status', 'Disetujui KBG'], ['lingkungan', $ling2]])->count();
            $jumlah_krisma = Krisma::where([['jenis', 'Paroki Setempat'], ['status', 'Disetujui KBG'], ['lingkungan', $ling2]])->count();
            $jumlah_pelayanan_lainnya = PendaftaranPelayananLainnya::where([['status', 'Disetujui KBG'], ['lingkungan', $ling2]])->count();
            $jumlah_pengurapan = PengurapanOrangSakit::where([['status', 'Disetujui KBG'], ['lingkungan', $ling2]])->count();
    
            $pendaftaran_umat_lama = User::where([['status', 'Belum Tervalidasi'], ['lingkungan_id', $ling]])->count();
            $pendaftaran_umat_baru = Umat::where([['status', 'Disetujui KBG'], ['lingkungan_id', $ling]])->count();
    
            return view('dashboardadmin.indexlingkungan', compact('jumlah_umat', 'jumlah_umat_pria', 'jumlah_umat_wanita', 'jumlah_kepala_keluarga', 'jumlah_kbg', 'jumlah_baptis_bayi', 'jumlah_baptis_dewasa', 'jumlah_krisma', 'jumlah_komuni_pertama', 'jumlah_pelayanan_lainnya', 'pendaftaran_umat_lama', 'pendaftaran_umat_baru', 'jumlah_pengurapan'));
        }
    }
}
