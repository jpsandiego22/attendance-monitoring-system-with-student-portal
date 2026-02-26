<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->string('img')->nullable();
            $table->string('identification')->unique();
            $table->string('name');
            $table->string('year')->nullable();
            $table->string('section')->nullable();
            $table->timestamps();
            $table->integer('user_type'); 
            $table->boolean('lock')->default(false); // false = open, true = locked
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_details');
    }
}
