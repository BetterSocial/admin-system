<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTabelNewsLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('news_link', function (Blueprint $table) {
            $table->longText('site_name')->nullable()->change();
            $table->longText('image')->nullable()->change();
            $table->longText('keyword')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('news_link', function (Blueprint $table) {
            $table->string("site_name", 255)->nullable(true);
            $table->string("image", 255)->nullable(true);
            $table->string("keyword", 255)->nullable(true);
        });
    }
}
