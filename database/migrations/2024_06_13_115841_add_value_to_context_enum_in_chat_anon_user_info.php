<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValueToContextEnumInChatAnonUserInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         // Create the ENUM type
         DB::statement("CREATE TYPE context_enum AS ENUM ('other profile', 'chat', 'post', 'follow', 'auto message')");

         // Change the column type to the new ENUM type
         DB::statement("ALTER TABLE chat_anon_user_info ALTER COLUMN context TYPE context_enum USING context::text::context_enum");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Create the ENUM type
        DB::statement("CREATE TYPE context_enum AS ENUM ('other profile', 'chat', 'post', 'follow')");

        // Change the column type to the new ENUM type
        DB::statement("ALTER TABLE chat_anon_user_info ALTER COLUMN context TYPE context_enum USING context::text::context_enum");
    }
}
