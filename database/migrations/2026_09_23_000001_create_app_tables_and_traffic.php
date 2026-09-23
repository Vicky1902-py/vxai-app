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
        // 1. Pastikan kolom role_id, xp, level ada di tabel users
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'role_id')) {
                    $table->unsignedBigInteger('role_id')->default(3)->after('password'); // 1: Admin, 2: Guru, 3: Siswa
                }
                if (!Schema::hasColumn('users', 'xp')) {
                    $table->unsignedInteger('xp')->default(0)->after('role_id');
                }
                if (!Schema::hasColumn('users', 'level')) {
                    $table->unsignedInteger('level')->default(1)->after('xp');
                }
            });
        }

        // 2. Tabel roles
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('display_name')->nullable();
                $table->timestamps();
            });
        }

        // 3. Tabel global_settings
        if (!Schema::hasTable('global_settings')) {
            Schema::create('global_settings', function (Blueprint $table) {
                $table->id();
                $table->string('setting_key')->unique();
                $table->text('setting_value')->nullable();
                $table->timestamps();
            });
        }

        // 4. Tabel coding_submissions
        if (!Schema::hasTable('coding_submissions')) {
            Schema::create('coding_submissions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable()->index();
                $table->string('guest_name')->nullable();
                $table->longText('html_code')->nullable();
                $table->longText('css_code')->nullable();
                $table->longText('js_code')->nullable();
                $table->integer('score')->nullable()->default(0);
                $table->text('feedback')->nullable();
                $table->timestamps();
            });
        } else {
            Schema::table('coding_submissions', function (Blueprint $table) {
                if (!Schema::hasColumn('coding_submissions', 'guest_name')) {
                    $table->string('guest_name')->nullable()->after('user_id');
                }
                if (!Schema::hasColumn('coding_submissions', 'feedback')) {
                    $table->text('feedback')->nullable()->after('score');
                }
            });
        }

        // 5. Tabel visitor_traffic (Pemantau Trafik Pengunjung Real-time)
        if (!Schema::hasTable('visitor_traffic')) {
            Schema::create('visitor_traffic', function (Blueprint $table) {
                $table->id();
                $table->string('ip_address', 45)->nullable()->index();
                $table->string('page_url')->index();
                $table->string('referer')->nullable();
                $table->string('device', 20)->default('Desktop'); // Desktop, Mobile, Tablet
                $table->string('browser', 50)->nullable();
                $table->text('user_agent')->nullable();
                $table->timestamp('visited_at')->useCurrent()->index();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_traffic');
        Schema::dropIfExists('coding_submissions');
        Schema::dropIfExists('global_settings');
        Schema::dropIfExists('roles');
        
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'level')) $table->dropColumn('level');
                if (Schema::hasColumn('users', 'xp')) $table->dropColumn('xp');
                if (Schema::hasColumn('users', 'role_id')) $table->dropColumn('role_id');
            });
        }
    }
};
