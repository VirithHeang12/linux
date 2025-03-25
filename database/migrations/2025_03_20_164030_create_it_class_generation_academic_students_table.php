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
        Schema::create('it_class_generation_academic_students', function (Blueprint $table) {
            $table->id();

            $table->foreignId('it_class_generation_academic_id')
                ->nullable()
                ->index('it_class_generation_academic_id_index')
                ->constrained('it_class_generation_academics', 'id', 'fk_students_it_class_generation_academic_id')
                ->comment('Foreign key to it_class_generation_academics table');

            $table->foreignId('student_id')
                ->nullable()
                ->index()
                ->constrained('students')
                ->comment('Foreign key to students table');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('it_class_generation_academic_students');
    }
};
