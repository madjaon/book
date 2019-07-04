<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosttyperelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posttyperelations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id')->nullable()->default(0);
            $table->integer('posttype_id')->nullable()->default(0);
            $table->index('post_id');
            $table->index('posttype_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posttyperelations', function($table) {
            $table->dropIndex('post_id');
            $table->dropIndex('posttype_id');
        });
        
        Schema::dropIfExists('posttyperelations');
    }
}
