<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePosttypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posttypes', function (Blueprint $table) {
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
            $table->string('lang')->nullable()->default(LANG1);
            $table->tinyInteger('status')->nullable()->default(1);
            $table->string('start_date')->nullable();
            $table->timestamps();
            $table->index(['slug', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posttypes', function($table) {
            $table->dropIndex(['slug', 'status']);
        });

        Schema::dropIfExists('posttypes');
    }
}
