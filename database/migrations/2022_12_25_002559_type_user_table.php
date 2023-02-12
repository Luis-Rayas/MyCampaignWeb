<?php

use App\Models\TypeUser;
use Database\Seeders\TypeUserSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TypeUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('type_users');
        Schema::create('type_users', function (Blueprint $table) {
            $table->id();
            $table->enum('nombre', ['Administrator', 'Sympathizer']);
            $table->timestamps();
            $table->softDeletes();
        });
        //TODO Cambiar esto por la ejecucion del seeder
        $administrator = new TypeUser(['nombre' => 'Administrator']);
        $administrator->save();
        $sympathizer = new TypeUser(['nombre' => 'Sympathizer']);
        $sympathizer->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type_users');
    }
}
