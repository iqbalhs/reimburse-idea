<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Role::create(['name' => 'superadmin']);
        Role::create(['name' => 'finance']);
        Role::create(['name' => 'hr']);
        Role::create(['name' => 'karyawan']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Role::truncate();
    }
};
