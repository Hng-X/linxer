<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinkTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
           Schema::create('link_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('link_id');
            $table->string('tags_id');
            $table->timestamps();
            

            $table->foreign('link_id')
                  ->references('id')->on('links')
                  ->onDelete('cascade');

            $table->foreign('tags_id')
                  ->references('id')->on('tags')
                  ->onDelete('cascade');
        });  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('link_tags');
    }
}
