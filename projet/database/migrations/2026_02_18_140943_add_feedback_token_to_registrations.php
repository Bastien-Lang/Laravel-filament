<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('feedback_token')->nullable()->unique();
            $table->text('feedback_comment')->nullable();
            $table->integer('feedback_rating')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn(['feedback_token', 'feedback_comment', 'feedback_rating']);
        });
    }
};
