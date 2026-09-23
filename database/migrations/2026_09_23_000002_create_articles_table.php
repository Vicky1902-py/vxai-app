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
        if (!Schema::hasTable('articles')) {
            Schema::create('articles', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique()->index();
                $table->string('category', 50)->default('coding')->index(); // coding, ai, teknologi, komputer, android
                $table->text('summary')->nullable();
                $table->longText('content');
                $table->string('thumbnail_url')->nullable();
                $table->unsignedBigInteger('author_id')->nullable()->index();
                $table->string('author_name')->default('Admin Editorial');
                $table->unsignedInteger('views_count')->default(0);
                $table->string('status', 20)->default('published')->index(); // published, draft
                $table->boolean('is_featured')->default(false)->index();
                $table->timestamp('published_at')->nullable()->index();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
