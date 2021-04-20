<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("INSERT INTO public.domain_page(domain_name, logo, short_description, created_at, updated_at)
        VALUES ('kompas.com','', 'Ini kompas', now(), now()),
        ('cnbcindonesia.com','','Berita ekonomi dan bisnis',now(),now()),
        ('news.detik.com','','Berita mancanegara',now(),now()),
        ('hot.detik.com','','Berita hot',now(),now()),
        ");
    }
}
