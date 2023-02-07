<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Section;
use Illuminate\Support\Str;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $section = Section::create([
            'section' => '111',
            'state_id' => 1,
            'municipality_id' => 1,
            'federal_district_id' => 1,
            'local_district_id' => 1
        ]);
    }
}
