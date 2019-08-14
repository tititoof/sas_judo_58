<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJudoEventsUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('judo_events_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('judo_event_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->boolean('participate')->default(false);

            $table->foreign('judo_event_id')->references('id')->on('judo_events');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('judo_events_users');
    }
}
