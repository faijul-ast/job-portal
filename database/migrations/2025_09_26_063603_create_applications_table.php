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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            // Explicitly reference job_postings instead of jobs
            $table->foreignId('job_posting_id')
                ->constrained('job_postings')
                ->cascadeOnDelete();

            $table->string('source', 50)->index(); // indeed, linkedin, etc.
            $table->string('source_app_id', 191)->index(); // id from provider
            $table->string('candidate_email', 191)->nullable()->index();
            $table->string('candidate_name', 191)->nullable();
            $table->string('candidate_phone', 50)->nullable();
            $table->string('resume_url')->nullable();
            $table->string('status', 50)->default('new'); // new, reviewed, rejected, hired
            $table->json('raw_payload')->nullable();
            $table->timestamps();

            $table->unique(['job_posting_id', 'source', 'source_app_id']); // idempotency
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
