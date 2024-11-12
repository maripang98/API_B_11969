<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesertasTable extends Migration
{
    public function up()
    {
        Schema::create('pesertas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_event')->constrained('events')->onDelete('cascade');
            $table->string('nama', 255);
            $table->string('email', 255);
            $table->string('telepon', 255);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pesertas');
    }
};

