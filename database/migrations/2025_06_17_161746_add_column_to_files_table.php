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
        Schema::table('files', function (Blueprint $table) {
            if (!Schema::hasColumn('files', 'hash')) {
                $table->string('hash', 64)->nullable();
            }

            if (!Schema::hasColumn('files', 'integrity_verified')) {
                $table->boolean('integrity_verified')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('files', function (Blueprint $table) {
            if (Schema::hasColumn('files', 'integrity_verified')) {
                $table->dropColumn('integrity_verified');
            }
            if (Schema::hasColumn('files', 'hash')) {
                $table->dropColumn('hash');
            }
        });
    }
};
