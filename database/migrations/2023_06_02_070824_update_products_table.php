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
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('popular')->default(false)->change();
            $table->boolean('featured')->default(false)->change();
            $table->boolean('status')->default(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('popular')->default('0')->change();
            $table->string('featured')->default('0')->change();
            $table->string('status')->default('0')->change();
        });
    }
};
