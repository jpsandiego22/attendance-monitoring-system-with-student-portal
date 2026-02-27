<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('detail_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_detail_id'); 
            $table->string('identification');
            $table->string('name');
            $table->time('t_in');
            $table->time('t_out')->nullable(); 
            $table->timestamps();

           
        });
    }
    public function down()
    {
        Schema::dropIfExists('detail_logs');
    }
}
