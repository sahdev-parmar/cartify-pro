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
            $table->tinyInteger('gender')->default(1)->comment("(1)->female,(0)->male");
            $table->string('mobile_number', 20)->nullable();
            $table->text('address')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->removeColumn('gender');
            $table->removeColumn('mobile_number');
            $table->removeColumn('address');
            $table->removeColumn('city_id');
            $table->removeColumn('state_id');
            $table->removeColumn('country_id');
        });
    }
};
