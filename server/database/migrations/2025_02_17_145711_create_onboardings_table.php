<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('onboardings', function (Blueprint $table) {
      $table->id();
      $table->string('email')->unique();
      $table->string('address');
      $table->string('phone')->nullable();
      $table->boolean('is_emergency')->default(false);
      $table->enum('property_type', ['residential_house', 'commercial_shop', 'office_building', 'industrial_warehouse']);
      $table->enum('time', ['morning', 'afternoon', 'evening', 'anytime']);
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('onboardings');
  }
};
