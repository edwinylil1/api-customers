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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('doc_customer', 15)->unique();
            $table->string('name', 250)->index();
            $table->string('email', 50)->unique();
            $table->string('phone', 15)->nullable();
            $table->string('business_address', 250);
            $table->char('api_status', 2)->default('4');
            $table->char('active', 1)->nullable();
            $table->string('address_delivery', 250)->nullable();
            $table->string('state', 20)->nullable();
            $table->string('city', 20)->nullable();
            $table->char('type_tax_1', 1)->nullable();
            $table->decimal('credit_limit', 20, 4)->nullable();
            $table->string('web_customer', 15)->nullable();
            $table->string('local_customer', 8)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
