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
            $table->string('user_id', 16)->unique();
            $table->string('dni', 15)->nullable();
            $table->string('country', 100)->default('Venezuela');
            $table->string('state', 100)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('telephone', 15)->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('user_id');
             $table->dropColumn('dni');
             $table->dropColumn('country');
             $table->dropColumn('state');
             $table->dropColumn('address');
             $table->dropColumn('telephone');
             $table->dropSoftDeletes();
        });
    }
};
