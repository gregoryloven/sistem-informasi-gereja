<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // Tenant::checkCurrent()
        //    ? $this->runTenantSpecificSeeders()
        //    : $this->runLandlordSpecificSeeders();
        $this->call(ParokiSeeder::class);
        $this->call(LingkunganSeeder::class);
        $this->call(KbgSeeder::class);
        $this->call(PelayananLainnya::class);
        $this->call(PetugasLiturgi::class);
    }

    public function runTenantSpecificSeeders()
    {
        $this->call(ParokiSeeder::class);
    }

    public function runLandlordSpecificSeeders()
    {
        // run landlord specific seeders
        $this->call(LandlordSeeder::class);
    }
}
