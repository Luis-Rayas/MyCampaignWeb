<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FederalDistrict;
use Illuminate\Support\Str;

class FederalDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $federalDistrict = FederalDistrict::create([
            'name' => 'distrito federal',
            'number' => 1
        ]);
    }
}
