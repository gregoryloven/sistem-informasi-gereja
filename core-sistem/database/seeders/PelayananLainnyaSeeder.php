<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PelayananLainnyaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pelayanan_lainnyas')->insert([
        	'jenis_pelayanan' => 'Pemberkatan',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('pelayanan_lainnyas')->insert([
        	'jenis_pelayanan' => 'Misa Syukur',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
