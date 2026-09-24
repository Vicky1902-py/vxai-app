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
        if (!Schema::hasTable('playground_challenges')) {
            Schema::create('playground_challenges', function (Blueprint $table) {
                $table->id();
                $table->string('slug')->unique()->index();
                $table->string('title');
                $table->string('level', 30)->default('pemula')->index(); // pemula, menengah, mahir
                $table->string('level_badge')->default('🟢 Pemula (HTML5)');
                $table->string('category', 50)->default('html')->index(); // html, css, javascript, ai, responsive, fullstack
                $table->text('desc')->nullable();
                $table->longText('instructions')->nullable(); // JSON array teks instruksi
                $table->longText('html_code')->nullable();
                $table->longText('css_code')->nullable();
                $table->longText('js_code')->nullable();
                $table->integer('order_num')->default(1)->index();
                $table->boolean('is_active')->default(true)->index();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('playground_challenges');
    }
};
