<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public $timestamps = false; 
    
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function(Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('price'); 
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
};
