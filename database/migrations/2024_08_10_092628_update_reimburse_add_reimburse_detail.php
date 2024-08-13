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
        Schema::table('reimburse', function (Blueprint $table) {
            $table->bigInteger('jumlah_total')->default(0)->after('remark');
        });

        Schema::create('reimburse_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->bigInteger('jumlah')->default(0);
            $table->unsignedInteger('file_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reimburse', function (Blueprint $table) {
            $table->drop('jumlah_total');
        });

        Schema::drop('reimburse_detail');
    }
};
