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
            //
            $table->softDeletes();
            $table->boolean('account_status')->default(true);
            $table->string('account_inactive_reason')->nullable();
            $table->timestamp('account_inactive_since')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropSoftDeletes();
            $table->dropColumn('account_status');
            $table->dropColumn('account_inactive_since');
        });
    }
};
