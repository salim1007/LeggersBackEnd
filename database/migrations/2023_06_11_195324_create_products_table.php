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
            $table->string('category_id');
            $table->string('brand_id');
            $table->string('name');
            $table->integer('originalPrice');
            $table->integer('sellingPrice');
            $table->string('prSection');
            $table->string('colour');
            $table->integer('qty');
            $table->string('size');
            $table->string('image')->nullable();
            $table->longText('description');
            $table->boolean('popular')->default(false);
            $table->boolean('featured')->default(false);
            $table->boolean('status')->default(false);
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
