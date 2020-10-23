<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('post');
            $table->string('slug')->unique();
            $table->string('user_id');
            $table->string('featuredImage')->nullable();
            $table->string('metaDescription');
            $table->integer('views')->default();
            $table->text('post_excerpt');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users'); 
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blogs');
    }
}
