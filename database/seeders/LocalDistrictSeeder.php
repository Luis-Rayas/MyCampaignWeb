<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LocalDistrict;
use Illuminate\Support\Str;

class LocalDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $localDistrict = LocalDistrict::create([
            'name' => 'distrito local',
            'number' => 1
        ]);
    }
}
