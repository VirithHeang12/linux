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
        Schema::create('it_class_generations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('it_class_id')
                ->nullable()
                ->index()
                ->constrained('it_classes')
                ->onDelete('cascade')
                ->onUpdate('cascade')
                ->comment('Foreign key to it_classes table');

            $table->foreignId('generation_id')
                ->nullable()
                ->index()
                ->constrained('generations')
                ->onDelete('cascade')
                ->onUpdate('cascade')
                ->comment('Foreign key to generations table');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('it_class_generations');
    }
};
