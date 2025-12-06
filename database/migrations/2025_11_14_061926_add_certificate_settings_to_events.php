<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCertificateSettingsToEvents extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            // path template sudah ada? kalau belum tambahkan
            if (!Schema::hasColumn('events', 'certificate_template')) {
                $table->string('certificate_template')->nullable();
            }

            $table->integer('name_x')->nullable()->after('certificate_template'); // px from left
            $table->integer('name_y')->nullable()->after('name_x'); // px from top
            $table->integer('name_font_size')->nullable()->after('name_y'); // px
            $table->string('name_color')->nullable()->after('name_font_size'); // hex color
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['certificate_template','name_x','name_y','name_font_size','name_color']);
        });
    }
}
