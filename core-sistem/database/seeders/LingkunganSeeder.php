<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Carbon\Carbon;

class LingkunganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lingkungans')->insert([
            'paroki_id' => '1',
        	'nama_lingkungan' => 'Regina Pacis',
            'batasan_wilayah' => 'Sanur-Renon',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('lingkungans')->insert([
            'paroki_id' => '1',
        	'nama_lingkungan' => 'Ratu Rosari',
            'batasan_wilayah' => 'Panjer-Sesetan',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
