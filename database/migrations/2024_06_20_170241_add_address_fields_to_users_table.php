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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('town_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('dni')->nullable();
            $table->string('social_security_number')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('nationality')->nullable();
            $table->date('date_of_birth')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['town_id']);
            $table->dropColumn('town_id');
            $table->dropColumn('address');
            $table->dropColumn('zip_code');
            $table->dropColumn('phone');
            $table->dropColumn('mobile');
            $table->dropColumn('dni');
            $table->dropColumn('social_security_number');
            $table->dropColumn('is_active');
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('nationality');
        });
    }
};
