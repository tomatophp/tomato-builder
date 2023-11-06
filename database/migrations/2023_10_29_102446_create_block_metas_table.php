<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('block_metas', function (Blueprint $table) {
            $table->id();

            //Link to Block
            $table->foreignId('block_id')->constrained('blocks');

            $table->string('type')->default('h1')->nullable();


            //Morph
            $table->unsignedBigInteger('model_id')->nullable();
            $table->string('model_type')->nullable();

            $table->json('text');

            //Code
            $table->longText('html')->nullable();
            $table->longText('css')->nullable();

            $table->integer('ordering')->default(1)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('block_metas');
    }
};
