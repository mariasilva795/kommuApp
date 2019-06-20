<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SpeakerTheme extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('speaker_theme', function (Blueprint $table){

          $table->integer('speaker_id')->unsigned();
          $table->integer('theme_id')->unsigned();

          $table->foreign("theme_id")->references("id")->on("themes");
          $table->foreign("speaker_id")->references("id")->on("speakers")->onDelete('CASCADE');
        
        });
    }


    public function down()
    {
        Schema::dropIfExists('speaker_theme');
    }
}

