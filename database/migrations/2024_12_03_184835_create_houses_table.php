<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHousesTable extends Migration
{
    public function up()
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('owner');
            $table->integer('rooms');
            $table->integer('bathrooms');
            $table->decimal('square_footage', 6, 2);
            $table->string('status');
            $table->foreignId('cluster_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('houses');
    }
}
