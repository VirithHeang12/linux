<?php

use App\Enums\Gender;
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
        Schema::create('students', function (Blueprint $table) {
            $table->id();

            $table->string('student_id')
                ->unique()
                ->comment('Student ID from the school');

            $table->string('first_name')
                ->comment('First name of the student');

            $table->string('last_name')
                ->comment('Last name of the student');

            $table->enum('gender',
                [
                    Gender::MALE->value,
                    Gender::FEMALE->value,
                    Gender::OTHER->value
                ])->default(Gender::OTHER->value)
                ->comment('Gender of the student');

            $table->date('date_of_birth')
                ->nullable()
                ->comment('Date of birth of the student');

            $table->string('address')
                ->nullable()
                ->comment('Address of the student');

            $table->string('email')
                ->unique()
                ->comment('Email of the student');

            $table->string('phone')
                ->nullable()
                ->comment('Phone number of the student');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
