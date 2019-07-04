<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosttagrelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posttagrelations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id')->nullable()->default(0);
            $table->integer('posttag_id')->nullable()->default(0);
            $table->index('post_id');
            $table->index('posttag_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posttagrelations', function($table) {
            $table->dropIndex('post_id');
            $table->dropIndex('posttag_id');
        });

        Schema::dropIfExists('posttagrelations');
    }
}
