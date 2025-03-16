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
        Schema::create('academics', function (Blueprint $table) {
            $table->id();

            $table->string('year')
                ->comment('Year of the academic year. e.g. Year 1, Year 2, etc.');

            $table->date('start_date')
                ->comment('Start date of the academic year');

            $table->date('end_date')
                ->comment('End date of the academic year');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academics');
    }
};
