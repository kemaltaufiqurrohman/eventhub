<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('certificate')->nullable()->after('status');
            $table->string('status_event')->default('Berlangsung')->after('certificate'); // 'Berlangsung' / 'Selesai'
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['certificate', 'status_event']);
        });
    }
};
