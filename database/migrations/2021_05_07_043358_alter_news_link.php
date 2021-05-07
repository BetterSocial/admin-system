<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNewsLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('news_link');

        Schema::create('news_link', function (Blueprint $table) {
            $table->uuid("news_link_id");
            $table->longText("news_url");
            $table->uuid("domain_page_id");
            $table->string("site_name",255)->nullable(true);
            $table->string("title",255)->nullable(true);
            $table->string("image",255)->nullable(true);
            $table->longText("description")->nullable(true);
            $table->longText("url")->nullable(true);
            $table->string("keyword",255)->nullable(true);
            $table->string("author",255)->nullable(true);
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
        });

        DB::statement('ALTER TABLE news_link ALTER COLUMN news_link_id SET DEFAULT uuid_generate_v4 ()');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
