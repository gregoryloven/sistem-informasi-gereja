<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListEvent;
use App\Models\Baptis;
use App\Models\KomuniPertama;
use App\Models\Krisma;
use App\Models\Kpp;
use App\Models\Perkawinan;
use App\Models\Riwayat;
use Carbon\Carbon;
use DB;
use Auth;
use DateTime;

class LaporanController extends Controller
{
    public function baptis(Request $request)
    {
        if(Auth::user()->role != 'admin')
        {
            return back();
        }
        else
        {
            $data = ListEvent::where('jenis_event', 'like', 'Baptis B%')
            ->orderby('jadwal_pelaksanaan', 'ASC')
            ->get();

            $array = [];
            $array2 = [];
            $array3 = [];
            foreach($data as $d)
            {
                $jumlah_baptis_bayi = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
                ->where([['riwayats.status', 'Disetujui Paroki'], ['list_events.id', $d->id]])->count();

                $jumlah_pendaftar_baptis_bayi = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
                ->where([['riwayats.status', 'Diproses'], ['list_events.id', $d->id]])
                ->count();

                $jumlah_gagal_baptis_bayi = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
                ->where([['riwayats.status', 'Ditolak'], ['list_events.id', $d->id]])
                ->orwhere([['riwayats.status', 'Dibatalkan'], ['list_events.id', $d->id]])
                ->count();
    
                array_push($array, $jumlah_baptis_bayi);
                array_push($array2, $jumlah_pendaftar_baptis_bayi);
                array_push($array3, $jumlah_gagal_baptis_bayi);
            }

            $startDate = $request->datetimepicker3;
            $endDate = $request->datetimepicker6;                  
            
            $data2 = ListEvent::whereYear('jadwal_pelaksanaan', '>=', (int)$startDate)            
            ->whereYear('jadwal_pelaksanaan', '<=', (int)$endDate)
            ->where('jenis_event', 'like', 'Baptis B%')
            ->orderby('jadwal_pelaksanaan', 'ASC')
            ->get();  

            $array4 = [];
            $array5 = [];
            $array6 = [];
            foreach($data2 as $d)
            {
                $jumlah_baptis_bayi = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
                ->where([['riwayats.status', 'Disetujui Paroki'], ['list_events.id', $d->id]])->count();

                $jumlah_pendaftar_baptis_bayi = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
                ->where([['riwayats.status', 'Diproses'], ['list_events.id', $d->id]])->count();

                $jumlah_gagal_baptis_bayi = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
                ->where([['riwayats.status', 'Ditolak'], ['list_events.id', $d->id]])
                ->orwhere([['riwayats.status', 'Dibatalkan'], ['list_events.id', $d->id]])
                ->count();
    
                array_push($array4, $jumlah_baptis_bayi);
                array_push($array5, $jumlah_pendaftar_baptis_bayi);
                array_push($array6, $jumlah_gagal_baptis_bayi);
            }
    
            return view('laporan.baptis',compact("data","data2","array","array2","array3",'startDate','endDate','array4','array5','array6'));
        }
    }

    public function detailgagal(Request $request)
    {
        $id = $request->id;
        $data = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
        ->join('baptiss', 'riwayats.event_id', '=', 'baptiss.id')
        ->where([['riwayats.list_event_id', $id], ['riwayats.status', 'Ditolak']])
        ->orwhere([['riwayats.list_event_id', $id], ['riwayats.status', 'Dibatalkan']])
        ->get(['baptiss.*', 'riwayats.*']);
        
        return view('laporan.detailBaptis',compact("data"));
    }

    public function baptisDewasa(Request $request)
    {
        if(Auth::user()->role != 'admin')
        {
            return back();
        }
        else
        {
            $data = ListEvent::where('jenis_event', 'like', 'Baptis D%')
            ->orderby('jadwal_pelaksanaan', 'ASC')
            ->get();

            $array = [];
            $array2 = [];
            $array3 = [];
            foreach($data as $d)
            {
                $jumlah_baptis_dewasa = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
                ->where([['riwayats.status', 'Disetujui Paroki'], ['list_events.id', $d->id]])->count();

                $jumlah_pendaftar_baptis_dewasa = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
                ->where([['riwayats.status', 'Diproses'], ['list_events.id', $d->id]])->count();

                $jumlah_gagal_baptis_dewasa = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
                ->where([['riwayats.status', 'Ditolak'], ['list_events.id', $d->id]])
                ->orwhere([['riwayats.status', 'Dibatalkan'], ['list_events.id', $d->id]])
                ->count();
    
                array_push($array, $jumlah_baptis_dewasa);
                array_push($array2, $jumlah_pendaftar_baptis_dewasa);
                array_push($array3, $jumlah_gagal_baptis_dewasa);
            }

            $startDate = $request->datetimepicker3;
            $endDate = $request->datetimepicker6;                  
            
            $data2 = ListEvent::whereYear('jadwal_pelaksanaan', '>=', (int)$startDate)            
            ->whereYear('jadwal_pelaksanaan', '<=', (int)$endDate)
            ->where('jenis_event', 'like', 'Baptis D%')
            ->orderby('jadwal_pelaksanaan', 'ASC')
            ->get();

            $array4 = [];
            $array5 = [];
            $array6 = [];
            foreach($data2 as $d)
            {
                $jumlah_baptis_dewasa = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
                ->where([['riwayats.status', 'Disetujui Paroki'], ['list_events.id', $d->id]])->count();

                $jumlah_pendaftar_baptis_dewasa = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
                ->where([['riwayats.status', 'Diproses'], ['list_events.id', $d->id]])->count();

                $jumlah_gagal_baptis_dewasa = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
                ->where([['riwayats.status', 'Ditolak'], ['list_events.id', $d->id]])
                ->orwhere([['riwayats.status', 'Dibatalkan'], ['list_events.id', $d->id]])
                ->count();
    
                array_push($array4, $jumlah_baptis_dewasa);
                array_push($array5, $jumlah_pendaftar_baptis_dewasa);
                array_push($array6, $jumlah_gagal_baptis_dewasa);
            }

    
            return view('laporan.baptisDewasa',compact("data","data2","array","array2","array3","array4","array5","array6","startDate","endDate"));
        }
    }

    public function detailgagaldewasa(Request $request)
    {
        $id = $request->id;
        $data = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
        ->join('baptiss', 'riwayats.event_id', '=', 'baptiss.id')
        ->where([['riwayats.list_event_id', $id], ['riwayats.status', 'Ditolak']])
        ->orwhere([['riwayats.list_event_id', $id], ['riwayats.status', 'Dibatalkan']])
        ->get(['baptiss.*', 'riwayats.*']);
        
        return view('laporan.detailBaptisDewasa',compact("data"));
    }

    public function komuni(Request $request)
    {
        if(Auth::user()->role != 'admin')
        {
            return back();
        }
        else
        {
            $data = ListEvent::where('jenis_event', 'like', 'Ko%')
            ->orderby('jadwal_pelaksanaan', 'ASC')
            ->get();

            $array = [];
            $array2 = [];
            $array3 = [];
            $array4 = [];
            foreach($data as $d)
            {
                $jumlah_komuni = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
                ->where([['riwayats.status', 'Disetujui Paroki'], ['list_events.id', $d->id]])->count();
    
                $jumlah_lulus_kursus = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
                ->where([['kursus', 'Lulus'], ['list_events.id', $d->id]])->count();

                $rasio_umur = DB::select(DB::raw('SELECT COUNT(*) as jumlah, CASE WHEN umur <18 THEN "Remaja" WHEN umur >18 THEN "Dewasa" END as range_umur
                FROM (SELECT TIMESTAMPDIFF (YEAR, kp.tanggal_lahir, CURDATE()) as umur 
                FROM komuni_pertamas kp INNER JOIN riwayats r ON kp.id = r.event_id INNER JOIN list_events le ON r.list_event_id = le.id 
                WHERE le.id = '.$d->id.' AND r.status = "Disetujui Paroki"
                GROUP BY r.event_id, kp.tanggal_lahir) as a
                GROUP BY range_umur 
                ORDER by range_umur'));

                $jumlah_gagal_komuni = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
                ->where([['riwayats.status', 'Ditolak'], ['list_events.id', $d->id]])
                ->orwhere([['riwayats.status', 'Dibatalkan'], ['list_events.id', $d->id]])
                ->count();
    
                array_push($array, $jumlah_komuni);
                array_push($array2, $jumlah_lulus_kursus);
                array_push($array3, $rasio_umur);
                array_push($array4, $jumlah_gagal_komuni);
            }

            $startDate = $request->datetimepicker3;
            $endDate = $request->datetimepicker6;                  
            
            $data2 = ListEvent::whereYear('jadwal_pelaksanaan', '>=', (int)$startDate)            
            ->whereYear('jadwal_pelaksanaan', '<=', (int)$endDate)
            ->where('jenis_event', 'like', 'Ko%')
            ->orderby('jadwal_pelaksanaan', 'ASC')
            ->get();           
    
            $array5 = [];
            $array6 = [];
            $array7 = [];
            $array8 = [];
            foreach($data2 as $d)
            {
                $jumlah_komuni = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
                ->where([['riwayats.status', 'Disetujui Paroki'], ['list_events.id', $d->id]])->count();
    
                $jumlah_lulus_kursus = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
                ->where([['kursus', 'Lulus'], ['list_events.id', $d->id]])->count();

                $rasio_umur = DB::select(DB::raw('SELECT COUNT(*) as jumlah, CASE WHEN umur <18 THEN "Remaja" WHEN umur >18 THEN "Dewasa" END as range_umur
                FROM (SELECT TIMESTAMPDIFF (YEAR, kp.tanggal_lahir, CURDATE()) as umur 
                FROM komuni_pertamas kp INNER JOIN riwayats r ON kp.id = r.event_id INNER JOIN list_events le ON r.list_event_id = le.id 
                WHERE le.id = '.$d->id.' AND r.status = "Disetujui Paroki"
                GROUP BY r.event_id, kp.tanggal_lahir) as a
                GROUP BY range_umur 
                ORDER by range_umur'));

                $jumlah_gagal_komuni = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
                ->where([['riwayats.status', 'Ditolak'], ['list_events.id', $d->id]])
                ->orwhere([['riwayats.status', 'Dibatalkan'], ['list_events.id', $d->id]])
                ->count();
    
                array_push($array5, $jumlah_komuni);
                array_push($array6, $jumlah_lulus_kursus);
                array_push($array7, $rasio_umur);
                array_push($array8, $jumlah_gagal_komuni);
            }
    
            return view('laporan.komuni',compact("data", "array", "array2",'array3','array4','array5','array6','array7','array8','data2','startDate','endDate'));
        }
    }

    public function detailgagalkomuni(Request $request)
    {
        $id = $request->id;
        $data = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
        ->join('komuni_pertamas', 'riwayats.event_id', '=', 'komuni_pertamas.id')
        ->where([['riwayats.list_event_id', $id], ['riwayats.status', 'Ditolak']])
        ->orwhere([['riwayats.list_event_id', $id], ['riwayats.status', 'Dibatalkan']])
        ->get(['komuni_pertamas.*', 'riwayats.*']);
        
        return view('laporan.detailKomuni',compact("data"));
    }

    public function krisma(Request $request)
    {
        if(Auth::user()->role != 'admin')
        {
            return back();
        }
        else
        {
            $data = ListEvent::where('jenis_event', 'like', 'Kr%')
            ->orderby('jadwal_pelaksanaan', 'ASC')
            ->get();

            $array = [];
            $array2 = [];
            $array3 = [];
            $array4 = [];
            foreach($data as $d)
            {
                $jumlah_krisma = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
                ->where([['riwayats.status', 'Disetujui Paroki'], ['list_events.id', $d->id]])->count();
    
                $jumlah_lulus_kursus = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
                ->where([['kursus', 'Lulus'], ['list_events.id', $d->id]])->count();

                $rasio_umur = DB::select(DB::raw('SELECT COUNT(*) as jumlah, CASE WHEN umur <18 THEN "Remaja" WHEN umur >18 THEN "Dewasa" END as range_umur
                FROM (SELECT TIMESTAMPDIFF (YEAR, kp.tanggal_lahir, CURDATE()) as umur 
                FROM krismas kp INNER JOIN riwayats r ON kp.id = r.event_id INNER JOIN list_events le ON r.list_event_id = le.id 
                WHERE le.id = '.$d->id.' AND r.status = "Disetujui Paroki"
                GROUP BY r.event_id, kp.tanggal_lahir) as a
                GROUP BY range_umur 
                ORDER by range_umur'));

                $jumlah_gagal_krisma = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
                ->where([['riwayats.status', 'Ditolak'], ['list_events.id', $d->id]])
                ->orwhere([['riwayats.status', 'Dibatalkan'], ['list_events.id', $d->id]])
                ->count();
    
                array_push($array, $jumlah_krisma);
                array_push($array2, $jumlah_lulus_kursus);
                array_push($array3, $rasio_umur);
                array_push($array4, $jumlah_gagal_krisma);
            }

            $startDate = $request->datetimepicker3;
            $endDate = $request->datetimepicker6;                  
            
            $data2 = ListEvent::whereYear('jadwal_pelaksanaan', '>=', (int)$startDate)            
            ->whereYear('jadwal_pelaksanaan', '<=', (int)$endDate)
            ->where('jenis_event', 'like', 'Kr%')
            ->orderby('jadwal_pelaksanaan', 'ASC')
            ->get();  
    
            $array5 = [];
            $array6 = [];
            $array7 = [];
            $array8 = [];
            foreach($data2 as $d)
            {
                $jumlah_krisma = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
                ->where([['riwayats.status', 'Disetujui Paroki'], ['list_events.id', $d->id]])->count();
    
                $jumlah_lulus_kursus = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
                ->where([['kursus', 'Lulus'], ['list_events.id', $d->id]])->count();

                $rasio_umur = DB::select(DB::raw('SELECT COUNT(*) as jumlah, CASE WHEN umur <18 THEN "Remaja" WHEN umur >18 THEN "Dewasa" END as range_umur
                FROM (SELECT TIMESTAMPDIFF (YEAR, kp.tanggal_lahir, CURDATE()) as umur 
                FROM krismas kp INNER JOIN riwayats r ON kp.id = r.event_id INNER JOIN list_events le ON r.list_event_id = le.id 
                WHERE le.id = '.$d->id.' AND r.status = "Disetujui Paroki"
                GROUP BY r.event_id, kp.tanggal_lahir) as a
                GROUP BY range_umur 
                ORDER by range_umur'));

                $jumlah_gagal_krisma = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
                ->where([['riwayats.status', 'Ditolak'], ['list_events.id', $d->id]])
                ->orwhere([['riwayats.status', 'Dibatalkan'], ['list_events.id', $d->id]])
                ->count();
    
                array_push($array5, $jumlah_krisma);
                array_push($array6, $jumlah_lulus_kursus);
                array_push($array7, $rasio_umur);
                array_push($array8, $jumlah_gagal_krisma);
            }
    
            return view('laporan.krisma',compact("data", "array", "array2",'array3','array4','array5','array6','array7','array8','data2','startDate','endDate'));
        }
    }

    public function detailgagalkrisma(Request $request)
    {
        $id = $request->id;
        $data = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
        ->join('krismas', 'riwayats.event_id', '=', 'krismas.id')
        ->where([['riwayats.list_event_id', $id], ['riwayats.status', 'Ditolak']])
        ->orwhere([['riwayats.list_event_id', $id], ['riwayats.status', 'Dibatalkan']])
        ->get(['krismas.*', 'riwayats.*']);
        
        return view('laporan.detailKrisma',compact("data"));
    }

    public function kpp()
    {
        if(Auth::user()->role != 'admin')
        {
            return back();
        }
        else
        {
            $data = ListEvent::where('jenis_event', 'like', 'Kursus%')
            ->orderby('id', 'DESC')
            ->get();

            $array = [];
            $array2 = [];
            $array3 = [];
            $array4 = [];
            foreach($data as $d)
            {
                $jumlah_kpp = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
                ->where([['riwayats.status', 'Disetujui Paroki'], ['list_events.id', $d->id]])->count();

                $jumlah_pendaftar_kpp = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
                ->where([['riwayats.status', 'Diproses'], ['list_events.id', $d->id]])->count();
                
                $jumlah_lulus_kursus = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
                ->where([['kursus', 'Lulus'], ['list_events.id', $d->id]])->count();
    
                $jumlah_tidak_lulus_kursus = Riwayat::join('list_events', 'riwayats.list_event_id', '=', 'list_events.id')
                ->where([['kursus', 'Tidak Lulus'], ['list_events.id', $d->id]])->count();
    
                array_push($array, $jumlah_kpp);
                array_push($array2, $jumlah_pendaftar_kpp);
                array_push($array3, $jumlah_lulus_kursus);
                array_push($array4, $jumlah_tidak_lulus_kursus);
            }
    
            return view('laporan.kpp',compact("data","array","array2",'array3','array4'));
        }
    }

    public function perkawinan(Request $request)
    {        
        if(Auth::user()->role != 'admin')
        {
            return back();
        }
        else
        {
            $data = Perkawinan::where('status', 'Disetujui Paroki')->orderby('tanggal_perkawinan', 'DESC')->get();
            $abc = $request->jenis;

            if($request->jenis == '1')
            {
                $a = explode('-', $request->datetimepicker3);
                $b = explode('-', $request->datetimepicker6);

                if(empty($request->datetimepicker3 && $request->datetimepicker6))
                {
                    return view('laporan.perkawinan',compact('data'));
                }
                else
                {
                    $startDate = $a[1].'-'.$a[0].'-1 00:00:00';
                    $endDate = $b[1].'-'.$b[0].'-31 23:59:59';   
                    
                    $s = $request->datetimepicker3;
                    $e = $request->datetimepicker6;

                    $data2 = Perkawinan::where([['tanggal_perkawinan', '>=', $startDate], ['tanggal_perkawinan', '<=', $endDate]])->get();

                    return view('laporan.perkawinan',compact('data','data2','s','e'));
                }
            }
            elseif($request->jenis == '2')
            {
                $a = explode('-', $request->datetimepicker3);
                $b = explode('-', $request->datetimepicker6);  
        
                if(empty($request->datetimepicker3 && $request->datetimepicker6))
                {
                    return view('laporan.perkawinan',compact('data'));
                }
                else
                {
                    $startDate = $a[1].'-'.$a[0].'-1 00:00:00';
                    $endDate = $b[1].'-'.$b[0].'-31 23:59:59';

                    $s = $request->datetimepicker3;
                    $e = $request->datetimepicker6;  
            
                    $data3 = Perkawinan::join('users', 'perkawinans.user_id', 'users.id')
                    ->join('lingkungans', 'users.lingkungan_id', '=', 'lingkungans.id')
                    ->select(DB::raw('count(users.lingkungan_id) as jumlah_lingkungan'), 'lingkungans.nama_lingkungan as nama_lingkungan')
                    ->where('perkawinans.status', 'Disetujui Paroki')
                    ->where('perkawinans.tanggal_perkawinan', '>=', $startDate)
                    ->where('perkawinans.tanggal_perkawinan', '<=', $endDate)
                    ->groupby('lingkungans.nama_lingkungan')
                    ->get();
            
                    return view('laporan.perkawinan',compact('data','data3','s','e'));
                }
            }
            elseif($abc == '3')
            {
                $a = explode('-', $request->datetimepicker3);
                $b = explode('-', $request->datetimepicker6);  

                if(empty($request->datetimepicker3 && $request->datetimepicker6))
                {
                    return view('laporan.perkawinan',compact('data'));
                }
                else
                {
                    $startDate = $a[1].'-'.$a[0].'-1 00:00:00';
                    $endDate = $b[1].'-'.$b[0].'-31 23:59:59';

                    $s = $request->datetimepicker3;
                    $e = $request->datetimepicker6;  
            
                    $data4 = Perkawinan::select(DB::raw('count(perkawinans.id) as jumlah_katolik_katolik'))
                    ->where([['perkawinans.status', 'Disetujui Paroki'], ['perkawinans.agama_calon_suami', 'Katolik'], ['perkawinans.agama_calon_istri', 'Katolik']])
                    ->where('perkawinans.tanggal_perkawinan', '>=', $startDate)
                    ->where('perkawinans.tanggal_perkawinan', '<=', $endDate)
                    ->get();

                    $data5 = Perkawinan::select(DB::raw('count(perkawinans.id) as jumlah_katolik_nonkatolik'))
                    ->where([['perkawinans.status', 'Disetujui Paroki'], ['perkawinans.agama_calon_suami', 'Katolik'], ['perkawinans.agama_calon_istri', '!=', 'Katolik'], ['perkawinans.tanggal_perkawinan', '>=', $startDate], ['perkawinans.tanggal_perkawinan', '<=', $endDate]])
                    ->orwhere([['perkawinans.status', 'Disetujui Paroki'], ['perkawinans.agama_calon_istri', 'Katolik'], ['perkawinans.agama_calon_suami', '!=', 'Katolik'], ['perkawinans.tanggal_perkawinan', '>=', $startDate], ['perkawinans.tanggal_perkawinan', '<=', $endDate]])
                    ->get();

                    $data6 = Perkawinan::select(DB::raw('count(perkawinans.id) as jumlah_sesama_paroki'))
                    ->where([['perkawinans.status', 'Disetujui Paroki'], ['perkawinans.paroki_calon_suami', app('currentTenant')->name], ['perkawinans.paroki_calon_istri', app('currentTenant')->name]])
                    ->where('perkawinans.tanggal_perkawinan', '>=', $startDate)
                    ->where('perkawinans.tanggal_perkawinan', '<=', $endDate)
                    ->get();

                    $data7 = Perkawinan::select(DB::raw('count(perkawinans.id) as jumlah_sesama_dan_paroki_luar'))
                    ->where([['perkawinans.status', 'Disetujui Paroki'], ['perkawinans.paroki_calon_suami', app('currentTenant')->name], ['perkawinans.paroki_calon_istri', 'Paroki Luar'], ['perkawinans.tanggal_perkawinan', '>=', $startDate], ['perkawinans.tanggal_perkawinan', '<=', $endDate]])
                    ->orwhere([['perkawinans.status', 'Disetujui Paroki'], ['perkawinans.paroki_calon_suami', app('currentTenant')->name], ['perkawinans.paroki_calon_istri', 'Paroki Luar'], ['perkawinans.tanggal_perkawinan', '>=', $startDate], ['perkawinans.tanggal_perkawinan', '<=', $endDate]])
                    ->get();
                    
                    $data8 = Perkawinan::select(DB::raw('count(perkawinans.id) as jumlah_sesama_paroki_luar'))
                    ->where([['perkawinans.status', 'Disetujui Paroki'], ['perkawinans.paroki_calon_suami', 'Paroki Luar'], ['perkawinans.paroki_calon_istri', 'Paroki Luar']])
                    ->where('perkawinans.tanggal_perkawinan', '>=', $startDate)
                    ->where('perkawinans.tanggal_perkawinan', '<=', $endDate)
                    ->get();
            
                    return view('laporan.perkawinan',compact('abc','data','data4','data5','data6','data7','data8','s','e'));
                }
            }
            // $startdate = Perkawinan::whereYear('tanggal_perkawinan', $request->datetimepicker3)->get();
            // $enddate = Perkawinan::whereYear('tanggal_perkawinan', $request->datetimepicker6)->get();
            // $data2 = Perkawinan::whereBetween('tanggal_perkawinan', [$startdate, $enddate])->get();

            //   $data2 = Perkawinan::whereYear('tanggal_perkawinan', '>', $startDate)             
            //   ->get();
            
            return view('laporan.perkawinan',compact('data'));
        }
    }

    public function detaillingkungan(Request $request)
    {
        $a = explode('-', $request->datetimepicker3);
        $b = explode('-', $request->datetimepicker6);  
        
        if(empty($request->datetimepicker3 && $request->datetimepicker6))
        {
            $startDate = "";
            $endDate = "";

            $data = Perkawinan::join('users', 'perkawinans.user_id', 'users.id')
            ->join('lingkungans', 'users.lingkungan_id', '=', 'lingkungans.id')
            ->select(DB::raw('count(users.lingkungan_id) as jumlah_lingkungan'), 'lingkungans.nama_lingkungan as nama_lingkungan')
            ->where('perkawinans.status', 'Disetujui Paroki')
            ->where('perkawinans.tanggal_perkawinan', '>=', $startDate)
            ->where('perkawinans.tanggal_perkawinan', '<=', $endDate)
            ->groupby('lingkungans.nama_lingkungan')
            ->get();
    
            return view('laporan.detailLingkunganPerkawinan',compact('data'));
        }
        else
        {
            $startDate = $a[1].'-'.$a[0].'-1 00:00:00';
            $endDate = $b[1].'-'.$b[0].'-31 00:00:00';
    
            $data = Perkawinan::join('users', 'perkawinans.user_id', 'users.id')
            ->join('lingkungans', 'users.lingkungan_id', '=', 'lingkungans.id')
            ->select(DB::raw('count(users.lingkungan_id) as jumlah_lingkungan'), 'lingkungans.nama_lingkungan as nama_lingkungan')
            ->where('perkawinans.status', 'Disetujui Paroki')
            ->where('perkawinans.tanggal_perkawinan', '>=', $startDate)
            ->where('perkawinans.tanggal_perkawinan', '<=', $endDate)
            ->groupby('lingkungans.nama_lingkungan')
            ->get();
    
            return view('laporan.detailLingkunganPerkawinan',compact('data'));
        }


    }

}
