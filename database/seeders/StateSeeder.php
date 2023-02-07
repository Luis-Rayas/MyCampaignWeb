<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;
use Illuminate\Support\Str;

class StateSeeder extends Seeder
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
    }
}
