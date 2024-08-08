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
        Schema::create('insulin_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('insulin_id');
            $table->float('quantity');
            $table->date('date');
            $table->time('hour');
            $table->unsignedInteger('created_by');
            $table->timestamps();

            $table->foreign('insulin_id')->references('id')->on('insulins')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('created_by')->references('id')->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insulin_logs');
    }
};
