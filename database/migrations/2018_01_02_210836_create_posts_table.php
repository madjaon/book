<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
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
            $table->text('images')->nullable();
            $table->integer('type_main_id')->nullable()->default(0);
            $table->tinyInteger('type')->nullable()->default(1);
            $table->integer('seri')->nullable()->default(0);
            $table->tinyInteger('nation')->nullable()->default(1); // 1.vietnam
            $table->tinyInteger('kind')->nullable()->default(1);
            $table->integer('view')->nullable()->default(0);
            $table->float('rating_value')->nullable()->default(0);
            $table->integer('rating_count')->nullable()->default(0);
            $table->string('lang')->nullable()->default(LANG1);
            $table->tinyInteger('status')->nullable()->default(1);
            $table->string('start_date')->nullable();
            $table->timestamps();
            $table->index('type');
            $table->index('seri');
            $table->index('nation');
            $table->index('kind');
            $table->index('slug');
            $table->index('status');
            $table->index('start_date');
        });

        DB::statement('ALTER TABLE '.env('DB_PREFIX').'posts ADD FULLTEXT search(slug, name)');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function($table) {
            $table->dropIndex('type');
            $table->dropIndex('seri');
            $table->dropIndex('nation');
            $table->dropIndex('kind');
            $table->dropIndex('slug');
            $table->dropIndex('status');
            $table->dropIndex('start_date');
            $table->dropIndex('search');
        });

        Schema::dropIfExists('posts');
    }
}
