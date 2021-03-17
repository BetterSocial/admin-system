<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE users DROP COLUMN profile_pic_path');
        Schema::table('users', function (Blueprint $table) {
            $table->longText('profile_pic_path')->nullable();
            $table->longText('profile_pic_asset_id')->nullable();
            $table->longText('profile_pic_public_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE users DROP COLUMN profile_pic_path');
        DB::statement('ALTER TABLE users DROP COLUMN profile_pic_asset_id');
        DB::statement('ALTER TABLE users DROP COLUMN profile_pic_public_id');
    }
}
