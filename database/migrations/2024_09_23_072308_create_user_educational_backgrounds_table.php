<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_educational_backgrounds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('degree');
            $table->string('institution');
            $table->string('session');
            $table->string('dept_group');
            $table->string('passingYear');
            $table->string('result');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_educational_backgrounds');
    }
};
