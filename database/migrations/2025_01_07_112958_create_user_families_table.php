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
        Schema::create('user_families', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('relation');
            $table->string('name');
            $table->string('religion')->nullable();
            $table->string('gender')->nullable();
            $table->date('birthDay')->nullable();
            $table->string('bloodGroup')->nullable();
            $table->unique('Phone')->nullable();
            $table->unique('Email')->nullable();
            $table->string('imagePath')->nullable();
            $table->string('anniversary')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_families');
    }
};
