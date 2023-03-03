<?php

use App\Models\TypeVolunteer;
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

            $table->string('name', 25);// 0 -> Representante general, 1 -> Representante de casilla, 2 -> Otro

            $table->timestamps();
            $table->softDeletes();
        });
        //TODO Cambiar esto por la ejecucion del seeder
        $type = new TypeVolunteer();
        $type->name = 'Representante general';
        $type->save();
        $type = new TypeVolunteer();
        $type->name = 'Representante casilla';
        $type->save();
        $type = new TypeVolunteer();
        $type->name = 'Otro';
        $type->save();

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
