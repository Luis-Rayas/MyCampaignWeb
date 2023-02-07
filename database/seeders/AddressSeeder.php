<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Address;
use Illuminate\Support\Str;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $address = Address::create([
            'street' => '111',
            'external_number' => '777',
            'internal_number' => '2',
            'suburb' => 'Netherlands',
            'zipcode' => '1234',
            'volunteer_id' => 1
        ]);
    }
}
