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
        Schema::table('skill_requests', function (Blueprint $table) {
            $table->dropColumn('offered_skill');
            $table->dropColumn('requested_skill');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('skill_requests', function (Blueprint $table) {
            $table->string('offered_skill')->nullable();
            $table->string('requested_skill')->nullable();
        });
    }
};
