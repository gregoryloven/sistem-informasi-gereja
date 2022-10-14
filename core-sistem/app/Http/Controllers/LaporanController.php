<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListEvent;
use App\Models\Baptis;
use App\Models\KomuniPertama;
use App\Models\Krisma;


class LaporanController extends Controller
{
    public function baptis()
    {
        $data = ListEvent::where('jenis_event', 'like', 'Baptis B%')
        ->orderby('jadwal_pelaksanaan', 'ASC')
        ->get();
        $jumlah_baptis_bayi = Baptis::where([['jenis', 'Baptis Bayi'], ['status', 'Selesai']])->count();

        return view('laporan.baptis',compact("data", "jumlah_baptis_bayi"));
    }

    public function baptisDewasa()
    {
        $data = ListEvent::where('jenis_event', 'like', 'Baptis D%')
        ->orderby('jadwal_pelaksanaan', 'ASC')
        ->get();
        $jumlah_baptis_dewasa = Baptis::where([['jenis', 'Baptis Dewasa'], ['status', 'Selesai']])->count();

        return view('laporan.baptisDewasa',compact("data", "jumlah_baptis_dewasa"));
    }

    public function komuni()
    {
        $data = ListEvent::where('jenis_event', 'like', 'Ko%')
        ->orderby('jadwal_pelaksanaan', 'ASC')
        ->get();
        $jumlah_komuni = KomuniPertama::where('status', 'Selesai')->count();
        $jumlah_lulus_kursus = KomuniPertama::where('kursus', 'Lulus')->count();

        return view('laporan.komuni',compact("data", "jumlah_komuni", "jumlah_lulus_kursus"));
    }

    public function krisma()
    {
        $data = ListEvent::where('jenis_event', 'like', 'Kr%')
        ->orderby('jadwal_pelaksanaan', 'ASC')
        ->get();
        $jumlah_krisma = Krisma::where('status', 'Selesai')->count();
        $jumlah_lulus_kursus = Krisma::where('kursus', 'Lulus')->count();

        return view('laporan.krisma',compact("data", "jumlah_krisma", "jumlah_lulus_kursus"));
    }

}
