<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VolunteersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteers', function (Blueprint $table) {
            $table->id();

            $table->string('name', 70);
            $table->string('fathers_lastname', 40); // Apellido paterno
            $table->string('mothers_lastname', 40); // Apellido materno
            $table->string('email');
            $table->string('phone', 20);

            $table->foreignId('section_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('campaign_id')->constrained();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('volunteers');
    }
}
