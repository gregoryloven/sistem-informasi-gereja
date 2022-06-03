<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Carbon\Carbon;

class KbgSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kbgs')->insert([
            'lingkungan_id' => '1',
        	'nama_kbg' => 'Agnes Angela',
            'batasan_wilayah' => 'Penyaringan-Batur Sari',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('kbgs')->insert([
            'lingkungan_id' => '2',
        	'nama_kbg' => 'Sebastianus',
            'batasan_wilayah' => 'Waturenggong-Pulau Moyo',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
