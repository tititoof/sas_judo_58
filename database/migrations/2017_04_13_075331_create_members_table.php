<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname')->default('firstname');
            $table->string('lastname')->default('lastname');
            $table->enum('sexe', ['Masculin', 'Féminin'])->default('Masculin');
            $table->datetime('birthday');
            $table->string('address')->default('address');
            $table->string('postal_code')->default('postal_code');
            $table->string('city')->default('city');
            $table->string('phone')->default('phone');
            $table->boolean('red_list')->default(true);
            $table->string('mobile')->default('mobile');
            $table->string('email')->default('email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
}
