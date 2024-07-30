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
        Schema::table('kategori', function(Blueprint $blueprint) {
            $blueprint->dateTime('created_at')->nullable();
            $blueprint->string('created_by')->nullable();
            $blueprint->dateTime('updated_at')->nullable();
            $blueprint->dateTime('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kategori', function(Blueprint $blueprint) {
            $blueprint->dropColumn('created_at');
            $blueprint->dropColumn('created_by');
            $blueprint->dropColumn('updated_at');
            $blueprint->dropColumn('updated_by');
        });
    }
};
