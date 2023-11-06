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
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();

            // Ref
            $table->string('type')->default('block')->nullable();
            $table->string('group')->nullable();

            // Info
            $table->string('key')->unique();
            $table->string('place')->default('body')->nullable();
            $table->integer('ordering')->default(1)->nullable();

            $table->boolean('activated')->default(true)->nullable();

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
        Schema::dropIfExists('blocks');
    }
};
