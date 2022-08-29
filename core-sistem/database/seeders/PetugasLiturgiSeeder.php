<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PetugasLiturgiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('petugas_liturgis')->insert([
        	'jenis_petugas' => 'Lektor',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('petugas_liturgis')->insert([
        	'jenis_petugas' => 'Pemazmur',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
