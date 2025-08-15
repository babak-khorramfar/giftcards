<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders','provider')) {
                $table->string('provider', 50)->nullable()->after('status')->index();
            }
            if (!Schema::hasColumn('orders','provider_order_id')) {
                $table->string('provider_order_id', 100)->nullable()->after('provider')->index();
            }
            if (!Schema::hasColumn('orders','meta')) {
                $table->json('meta')->nullable()->after('provider_order_id');
            }
            if (!Schema::hasColumn('orders','error_code')) {
                $table->string('error_code', 50)->nullable()->after('meta');
            }
            if (!Schema::hasColumn('orders','error_message')) {
                $table->string('error_message', 255)->nullable()->after('error_code');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['provider','provider_order_id','meta','error_code','error_message']);
        });
    }
};

