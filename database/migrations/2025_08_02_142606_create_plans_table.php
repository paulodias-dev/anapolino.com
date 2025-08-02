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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price_monthly', 10, 2);
            $table->decimal('price_yearly', 10, 2)->nullable();
            $table->integer('listing_limit')->default(0);
            $table->boolean('featured_listings')->default(false);
            $table->integer('featured_limit')->default(0);
            $table->boolean('recommendations')->default(false);
            $table->integer('recommendation_limit')->default(0);
            $table->integer('photo_limit')->default(1);
            $table->boolean('active')->default(true);
            $table->integer('order')->default(0);
            $table->string('stripe_monthly_id')->nullable();
            $table->string('stripe_yearly_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
