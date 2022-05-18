<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRssLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rss_links', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('domain_name', 100);
            $table->text('link');
            $table->timestamps();
        });


        DB::statement('ALTER TABLE rss_links ALTER COLUMN id SET DEFAULT uuid_generate_v4 ()');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rss_links');
    }
}
