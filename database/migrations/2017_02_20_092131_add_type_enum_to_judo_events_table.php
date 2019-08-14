<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeEnumToJudoEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('judo_events', function (Blueprint $table) {
            $table->enum('type', ['tournament', 'event', 'stage'])->default('event');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('judo_events', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
}
