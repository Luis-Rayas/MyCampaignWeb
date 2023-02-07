<?php

namespace Database\Seeders;

use App\Models\Administrator;
use Illuminate\Database\Seeder;

class AdministratorCampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $currentAdministrator = Administrator::get()->first();

        for ($i = 1; $i <= 20; $i++) {
            $currentAdministrator->campaigns()->attach($i);
        }

    }
}
