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
        Schema::table('reimburse_detail', function (Blueprint $table) {
            $table->integer('reimburse_id')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reimburse_detail', function (Blueprint $table) {
            $table->dropColumn('reimburse_id');
        });
    }
};
