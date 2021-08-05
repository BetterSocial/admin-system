<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableNewsLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_link', function (Blueprint $table) {
            $table->bigIncrements("news_link_id");
            $table->longText("news_url");
            $table->bigInteger("domain_page_id");
            $table->string("site_name", 255)->nullable(true);
            $table->string("title", 255)->nullable(true);
            $table->string("image", 255)->nullable(true);
            $table->longText("description")->nullable(true);
            $table->longText("url")->nullable(true);
            $table->string("keyword", 255)->nullable(true);
            $table->string("author", 255)->nullable(true);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_link');
    }
}
