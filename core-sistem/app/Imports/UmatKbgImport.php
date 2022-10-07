<?php

namespace App\Imports;

use App\Models\Umat;
use App\Models\Kbg;
use App\Models\Lingkungan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class UmatKbgImport implements ToCollection, WithHeadingRow
{
    public function Collection(collection $row)
    {
        foreach ($row as $r) {
            $kbg = Kbg::where('nama_kbg', $r['nama_kbg'])->first();
            $lingkungan = Lingkungan::where('nama_lingkungan', $r['nama_lingkungan'])->first();

            $umat = new Umat();
            $umat->nama_lengkap = $r['nama_lengkap'];
            $umat->hubungan = $r['hubungan'];
            $umat->jenis_kelamin = $r['jenis_kelamin'];

            $umat->lingkungan_id = $lingkungan->id;
            $umat->kbg_id = $kbg->id;

            $umat->alamat = $r['alamat'];
            $umat->telepon = $r['telepon'];
            $umat->status = "Disetujui Lingkungan";
            $umat->save();
        }
    }
}
