<?php

namespace Database\Seeders;

use App\Models\TypeUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $administrator = new TypeUser(['nombre' => 'Administrator']);
        $sympathizer = new TypeUser(['nombre' => 'Sympathizer']);
        DB::table('type_user')->insert([$administrator, $sympathizer]);
    }
}
