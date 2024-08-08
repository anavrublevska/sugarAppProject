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
        Schema::create('product_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->unsignedInteger('insulin_id');
            $table->unsignedInteger('sugar_before_id');
            $table->unsignedInteger('sugar_after_id');
            $table->unsignedInteger('grams');
            $table->float('carbohydrates')->nullable();
            $table->float('proteins')->nullable();
            $table->float('fats')->nullable();
            $table->date('date');
            $table->time('hour');
            $table->text('comment');
            $table->boolean('successful');
            $table->unsignedInteger('created_by');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('insulin_id')->references('id')->on('insulins')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('sugar_before_id')->references('id')->on('sugar_logs')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('sugar_after_id')->references('id')->on('sugar_logs')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('created_by')
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
        Schema::dropIfExists('product_logs');
    }
};
