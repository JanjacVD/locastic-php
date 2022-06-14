<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('fullName');
            $table->string('raceTime');
            $table->enum('distance', ['long', 'medium']);
            $table->integer('placement')->nullable();
            
            $table->unsignedBigInteger('race_id')->index();
            $table->foreign('race_id')
                ->references('id')
                ->on('races');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results');
    }
};
