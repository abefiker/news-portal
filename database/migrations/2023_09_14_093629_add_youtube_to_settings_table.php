<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('youtube')->nullable(); // Add this line to create the youtube column
        });
    }

    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('youtube'); // If you want to rollback, this line will drop the youtube column
        });
    }
};
