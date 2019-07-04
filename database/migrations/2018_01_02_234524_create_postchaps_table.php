<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostchapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postchaps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('summary', 500)->nullable();
            $table->text('content')->nullable();
            $table->string('image')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keyword')->nullable();
            $table->string('meta_description', 300)->nullable();
            $table->string('meta_image')->nullable();
            $table->integer('post_id')->nullable()->default(0);
            $table->integer('volume')->nullable()->default(0);
            $table->string('chapter')->nullable();
            $table->integer('position')->nullable()->default(0);
            $table->integer('view')->nullable()->default(0);
            $table->string('lang')->nullable()->default(LANG1);
            $table->tinyInteger('status')->nullable()->default(1);
            $table->string('start_date')->nullable();
            $table->timestamps();
            $table->index('post_id');
            $table->index('status');
            $table->index('start_date');
            $table->index(['slug', 'post_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('postchaps', function($table) {
            $table->dropIndex('post_id');
            $table->dropIndex('status');
            $table->dropIndex('start_date');
            $table->dropIndex(['slug', 'post_id']);
        });

        Schema::dropIfExists('postchaps');
    }
}
