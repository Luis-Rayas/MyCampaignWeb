<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AuxVolunteer;
use Illuminate\Support\Str;

class AuxVolunteerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $AuxVolunteer = AuxVolunteer::create([
            'image_path_ine' => 'image_path_ine.png',
            'image_path_firm' => 'image_path_firm.png',
            'birthdate' => '2000/09/05',
            'sector' => '1234',
            'type' => '0',
            'elector_key' => 'DJKAD82E932901',
            'local_voting_booth' => TRUE,
            'volunteer_id' => 1
        ]);
    }
}
