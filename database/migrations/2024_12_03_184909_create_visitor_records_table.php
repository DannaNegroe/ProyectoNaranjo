<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitorRecordsTable extends Migration
{
    public function up()
    {
        Schema::create('visitor_records', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->dateTime('entry');
            $table->dateTime('exit');
            $table->string('plate');
            $table->string('motive');
            $table->foreignId('house_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('visitor_records');
    }
}
