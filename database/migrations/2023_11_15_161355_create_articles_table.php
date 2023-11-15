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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content')->nullable();
            $table->text('source_url')->nullable();
            $table->dateTime('published_at');
            $table->text('image_url')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('source_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('author_id');

            $table->foreign('source_id')->references('id')->on('sources');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('author_id')->references('id')->on('authors');

            $table->index('title');
            $table->index('published_at');
            $table->index('source_id');
            $table->index('category_id');
            $table->index('author_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
