<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Carbon\Carbon;

class ParokiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parokis')->insert([
        	'nama_paroki' => 'Katedral Denpasar',
            'alamat' => 'Jl. Tukad Musi No. 1',
            'email' => 'katedraldenpasar@gmail.com',
            'telepon' => '(0361) 426392',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
