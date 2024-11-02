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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category')->nullable();
            $table->decimal('qtd_stock', 7, 2)->nullable();
            $table->unsignedInteger('qtd_min')->nullable();
            $table->enum('unit_type', ['ml', 'un'])->default('un');
            $table->unsignedInteger('quantity');
            $table->decimal('cost_price', 10, 2)->nullable();
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->unsignedInteger('qtd_service');
            $table->decimal('cost_per_service', 10, 2);
            $table->decimal('qtd_used_per_service', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
