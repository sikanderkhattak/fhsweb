<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeImageNullableInBlogsTable extends Migration
{
    public function up()
{
    Schema::table('blogs', function (Blueprint $table) {
        $table->string('image', 11)->nullable()->change();
    });
}

public function down()
{
    Schema::table('blogs', function (Blueprint $table) {
        $table->string('image', 11)->nullable(false)->change();
    });
}

}
