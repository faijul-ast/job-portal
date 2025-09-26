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
        Schema::create('job_postings', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');


            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');

            $table->string('company_name');

            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('street')->nullable();

            $table->enum('employment_type', ['full-time', 'part-time', 'contract', 'internship', 'temporary'])
                  ->nullable();

            $table->decimal('salary_min', 10, 2)->nullable();
            $table->decimal('salary_max', 10, 2)->nullable();
            $table->string('salary_currency', 10)->nullable();
            $table->enum('salary_period', ['hourly', 'daily', 'weekly', 'monthly', 'yearly'])->nullable();

            $table->date('valid_through')->nullable();
            $table->boolean('is_public')->default(true);
            $table->boolean('is_remote')->default(false);

            $table->string('external_ref')->nullable();
            $table->enum('status', ['draft', 'published', 'closed'])->default('draft');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_postings');
    }
};
