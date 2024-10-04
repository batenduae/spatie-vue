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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('addressType');
            $table->string('district');
            $table->string('typeVillageMunicipalityCity');
            $table->string('upazillaCity');
            $table->string('unionMunicipality');
            $table->string('wardCouncil')->nullable();
            $table->string('villageMohokuma')->nullable();
            $table->string('roadNo')->nullable();
            $table->string('houseNo')->nullable();
            $table->string('otherDetails')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
