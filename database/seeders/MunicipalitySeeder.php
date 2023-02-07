<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Municipality;
use Illuminate\Support\Str;

class MunicipalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $municipality = Municipality::create([
            'name' => 'municipio',
            'number' => 1
        ]);
    }
}
