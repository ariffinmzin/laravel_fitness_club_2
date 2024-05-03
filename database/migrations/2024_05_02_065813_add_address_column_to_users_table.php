<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('address_1')->after('email')->nullable();
            $table->string('address_2')->after('address_1')->nullable();
            $table->string('city')->after('address_2')->nullable();
            $table->string('state')->after('city')->nullable();
            $table->string('postcode')->after('state')->nullable();
            $table->integer('country_id')->after('postcode')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('address_1');
            $table->dropColumn('address_2');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('postcode');
            $table->dropColumn('country_id');

        });
    }
};
