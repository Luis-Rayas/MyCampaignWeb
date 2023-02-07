<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Volunteer;
use App\Models\State;
use App\Models\Municipality;
use App\Models\FederalDistrict;
use App\Models\LocalDistrict;
use App\Models\Section;
use App\Models\Sympathizer;
use App\Models\Address;
use App\Models\AuxVolunteer;
use App\Models\User;


class VolunteerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $state = State::create([
            'name' => 'Jalisco'
        ]);

        $municipality = Municipality::create([
            'name' => 'municipio',
            'number' => 1
        ]);

        $federalDistrict = FederalDistrict::create([
            'name' => 'distrito federal',
            'number' => 1
        ]);

        $localDistrict = LocalDistrict::create([
            'name' => 'distrito local',
            'number' => 1
        ]);

        $section = Section::create([
            'section' => '111',
            'state_id' => $state->id,
            'municipality_id' => $municipality->id,
            'federal_district_id' => $federalDistrict->id,
            'local_district_id' => $localDistrict->id
        ]);

        $sympathizer = Sympathizer::create([
            'name' => 'Moy',
            'authorized' => 1
        ]);

        $sympathizer->campaigns()->attach(1);

        $user = User::create([
            'email' => 'simpatizante@simpatizante.com',
            'password' => 'password',
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'userable_id' => $sympathizer->id,
            'userable_type' => 'App\Models\Sympathizer'
        ]);

        $volunteer = Volunteer::create([
            'name' => 'Dani',
            'fathers_lastname' => 'michel',
            'mothers_lastname' => 'ramirez',
            'email' => 'dani@mail.com',
            'phone' => '11223344',
            'section_id' => $section->id,
            'sympathizer_id' => $sympathizer->id,
            'campaign_id' => 1
        ]);

        $address = Address::create([
            'street' => '111',
            'external_number' => '777',
            'internal_number' => '2',
            'suburb' => 'Netherlands',
            'zipcode' => '1234',
            'volunteer_id' => $volunteer->id
        ]);

        $AuxVolunteer = AuxVolunteer::create([
            'image_path_ine' => 'image_path_ine.png',
            'image_path_firm' => 'image_path_firm.png',
            'birthdate' => '2000/09/05',
            'sector' => '1234',
            'type' => '0',
            'elector_key' => 'DJKAD82E932901',
            'local_voting_booth' => TRUE,
            'volunteer_id' => $volunteer->id
        ]);
    }
}
