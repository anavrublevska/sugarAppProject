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
        Schema::create('fantom_points', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->date('date');
            $table->integer('coord_x');
            $table->integer('coord_y');
            $table->string('color', 16);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fantom_points');
    }
};
