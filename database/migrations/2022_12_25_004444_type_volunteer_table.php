<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TypeVolunteerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('type_volunteers');
        Schema::create('type_volunteers', function (Blueprint $table) {
            $table->id();

            $table->string('name', 15);// 0 -> Representante general, 1 -> Representante de casilla, 2 -> Otro

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('aux_volunteers', function (Blueprint $table) {
            $table->foreignId('type_volunteer_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('type_volunteers');
    }
}
