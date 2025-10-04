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
            $table->string('name')->comment('Product name');
            $table->string('slug')->comment('Slug');
            $table->string('sku')->comment('Product SKU');
            $table->text('description')->comment('Product description');
            $table->decimal('price', 10, 2)->comment('Price');
            $table->enum('status', ['active', 'inactive'])->default('active')->comment('Product status');
            $table->softDeletes();
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
