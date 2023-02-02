<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ 

    public function up()
    {
        Schema::create('tickets', function(Blueprint $table) {
            $table->id();
            $table->string('customerId'); 
            $table->string('subs')->nullable(); 
            $table->string('queue')->nullable(); 
            $table->longText('roles')->nullable(); 
            $table->longText('notes')->nullable(); 
            $table->string('title')->nullable(); 
            $table->longText('description')->nullable(); 
            $table->integer('solved')->default(0); 
            $table->timestamps();
        });        
    }

    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};
