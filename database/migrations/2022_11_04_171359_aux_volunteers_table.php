<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AuxVolunteersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aux_volunteers', function (Blueprint $table) {
            $table->id();

            $table->string('image_path_ine')->nullable();
            $table->string('image_path_firm')->nullable();
            $table->date('birthdate');
            $table->string('notes', 512)->nullable();
            $table->string('sector', 50);
            $table->string('elector_key', 18)->unique();
            $table->boolean('local_voting_booth'); // Va a defender la casilla en la seccion

            $table->foreignId('type_volunteer_id')->constrained();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

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
        Schema::dropIfExists('aux_volunteers');
    }
}
