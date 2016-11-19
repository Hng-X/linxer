<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('domain_id');
            $table->string('url');
            $table->string('title')->nullable();
            $table->string('added_by');
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('added_by');
            $table->index('title');

            $table->foreign('domain_id')
                  ->references('id')->on('domains')
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
        Schema::dropIfExists('links');
    }
}

