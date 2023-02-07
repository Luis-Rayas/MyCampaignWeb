<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuxVolunteersTable extends Migration
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
            
            $table->string('image_path_ine');
            $table->string('image_path_firm');
            $table->date('birthdate');
            $table->string('notes', 512)->nullable();
            $table->string('sector', 50);
            //TODO Cambiar el enum por el tipo de voluntario
            $table->enum('type', ['0','1','2']); // 0 -> Representante general, 1 -> Representante de casilla, 2 -> Otro
            $table->string('elector_key', 18);
            $table->boolean('local_voting_booth'); // Va a defender la casilla en la seccion

            $table->foreignId('volunteer_id')->constrained()->onDelete('cascade');
            

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
