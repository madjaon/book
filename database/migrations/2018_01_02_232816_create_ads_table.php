<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('position')->nullable()->default(1);
            $table->text('code')->nullable();
            $table->string('image')->nullable();
            $table->string('url', 500)->nullable();
            $table->string('lang')->nullable()->default(LANG1);
            $table->tinyInteger('status')->nullable()->default(1);
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->timestamps();
            $table->index(['position', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ads', function($table) {
            $table->dropIndex(['position', 'status']);
        });
        
        Schema::dropIfExists('ads');
    }
}
