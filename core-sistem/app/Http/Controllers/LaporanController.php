<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListEvent;
use App\Models\Baptis;
use App\Models\KomuniPertama;
use App\Models\Krisma;
use App\Models\Kpp;
use App\Models\Riwayat;


class LaporanController extends Controller
{
    public function baptis()
    {
        $data = ListEvent::where('jenis_event', 'like', 'Baptis B%')
        ->orderby('jadwal_pelaksanaan', 'ASC')
        ->get();

        $array = [];
        foreach($data as $d)
        {
            $jumlah_baptis_bayi = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
            ->where([['riwayats.status', 'Selesai'], ['list_events.id', $d->id]])->count();

            array_push($array, $jumlah_baptis_bayi);
        }

        return view('laporan.baptis',compact("data", "array"));
    }

    public function baptisDewasa()
    {
        $data = ListEvent::where('jenis_event', 'like', 'Baptis D%')
        ->orderby('jadwal_pelaksanaan', 'ASC')
        ->get();

        $array = [];
        foreach($data as $d)
        {
            $jumlah_baptis_dewasa = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
            ->where([['riwayats.status', 'Selesai'], ['list_events.id', $d->id]])->count();

            array_push($array, $jumlah_baptis_dewasa);
        }

        return view('laporan.baptisDewasa',compact("data", "array"));
    }

    public function komuni()
    {
        $data = ListEvent::where('jenis_event', 'like', 'Ko%')
        ->orderby('jadwal_pelaksanaan', 'ASC')
        ->get();

        $array = [];
        $array2 = [];
        foreach($data as $d)
        {
            $jumlah_komuni = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
            ->where([['riwayats.status', 'Selesai'], ['list_events.id', $d->id]])->count();

            $jumlah_lulus_kursus = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
            ->where([['kursus', 'Lulus'], ['list_events.id', $d->id]])->count();

            array_push($array, $jumlah_komuni);
            array_push($array2, $jumlah_lulus_kursus);
        }

        return view('laporan.komuni',compact("data", "array", "array2"));
    }

    public function krisma()
    {
        $data = ListEvent::where('jenis_event', 'like', 'Kr%')
        ->orderby('jadwal_pelaksanaan', 'ASC')
        ->get();

        $array = [];
        $array2 = [];
        foreach($data as $d)
        {
            $jumlah_krisma = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
            ->where([['riwayats.status', 'Selesai'], ['list_events.id', $d->id]])->count();

            $jumlah_lulus_kursus = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
            ->where([['kursus', 'Lulus'], ['list_events.id', $d->id]])->count();

            array_push($array, $jumlah_krisma);
            array_push($array2, $jumlah_lulus_kursus);
        }

        return view('laporan.krisma',compact("data", "array", "array2"));
    }

    public function kpp()
    {
        $data = ListEvent::where('jenis_event', 'like', 'Kursus%')->get();

        $array = [];
        $array2 = [];
        foreach($data as $d)
        {
            $jumlah_lulus_kursus = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
            ->where([['kursus', 'Lulus'], ['list_events.id', $d->id]])->count();

            $jumlah_tidak_lulus_kursus = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
            ->where([['kursus', 'Tidak Lulus'], ['list_events.id', $d->id]])->count();

            array_push($array, $jumlah_lulus_kursus);
            array_push($array2, $jumlah_tidak_lulus_kursus);
        }

        return view('laporan.kpp',compact("data", "array", "array2"));
    }

}
