<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlterFileUploadsTableThumbPath extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('file_uploads', function (Blueprint $table) {
            $table->string('thumb_path')->nullable()->after('path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('file_uploads', function (Blueprint $table) {
            $table->dropColumn(['thumb_path']);
        });
    }
}
