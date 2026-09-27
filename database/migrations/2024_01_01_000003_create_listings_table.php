<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subcategory_id')->nullable()->constrained()->nullOnDelete();

            $table->enum('type', ['product', 'service'])->default('product');
            $table->string('name');
            $table->text('detail');
            $table->decimal('price', 12, 2)->default(0);

            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->string('area')->nullable();

            $table->longText('image')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // helps the city / city+category listing pages
            $table->index(['city', 'category_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
