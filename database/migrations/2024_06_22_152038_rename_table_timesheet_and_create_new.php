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
        // Esta migracion es por usar sqlite y no poder cambiar campos de una tabla

        //Comprobar si el env DB_CONNECTION=sqlite
        if (config('database.default') === 'sqlite') {
            Schema::rename('timesheets', 'timesheets_old_table');
            Schema::create('timesheets', function (Blueprint $table) {
                $table->id();
                $table->foreignId('calendar_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
                $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
                $table->enum('type', ['WORK', 'PAUSE', ])->default('WORK');
                $table->timestamp('day_in');
                $table->timestamp('day_out')->nullable();
                $table->timestamps();
            });

            Schema::dropIfExists('timesheets_old_table');
            return;
        }

        // Si no es sqlite se ejecuta la migracion normal
        Schema::table('timesheets', function (Blueprint $table) {
            $table->change('day_out', 'timestamp', ['nullable' => true]);
        });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
