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
        Schema::create('it_class_generation_academics', function (Blueprint $table) {
            $table->id();

            $table->foreignId('it_class_generation_id')
                ->nullable()
                ->index()
                ->constrained('it_class_generations')
                ->onDelete('cascade')
                ->onUpdate('cascade')
                ->comment('Foreign key to it_class_generations table');

            $table->foreignId('academic_id')
                ->nullable()
                ->index()
                ->constrained('academics')
                ->onDelete('cascade')
                ->onUpdate('cascade')
                ->comment('Foreign key to academics table');

            $table->string('room_no')
                ->comment('Room number of the class');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('it_class_generation_academics');
    }
};
