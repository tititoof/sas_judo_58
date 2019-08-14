<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeContentTextToLongTextOnArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('articles', function(Blueprint $table) {
            $table->renameColumn('content', 'content_text');
        });
        Schema::table('articles', function(Blueprint $table) {
            $table->dropColumn('content_text');
        });
        Schema::table('articles', function(Blueprint $table) {
            $table->longText('content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('articles', function(Blueprint $table) {
            $table->renameColumn('content', 'content_longt_text');
            $table->dropColumn('content_longt_text');
        });
        Schema::table('articles', function(Blueprint $table) {
            $table->text('content');
        });
    }
}
