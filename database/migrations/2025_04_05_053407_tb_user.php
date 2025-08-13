<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        schema::create('tb_user', function(Blueprint $table){
            $table->integer('id_user', true);
            $table->string('username', 50);
            $table->string('password',255);
            $table->integer('role');
            $table->timestamps();

        
        });
        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        schema::drop('tb_user');
        //
    }
};
