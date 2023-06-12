<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdditionalRSSForSchool extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement("INSERT INTO public.rss_links(domain_name,link,created_at,updated_at)
        VALUES ('harvard.edu','https://news.harvard.edu/gazette/section/news-announcements/feed/', now(), now()),
        ('harvard.edu', 'https://news.harvard.edu/gazette/section/campus-community/feed/',now(),now()),
        ('vanderbilt.edu', 'https://news.vanderbilt.edu/section/myvu/feed/',now(),now()),
        ('gostanford.com', 'http://gostanford.com/rss.aspx?path=mbball',now(),now()),
        ('gostanford.com', 'http://gostanford.com/rss.aspx?path=football',now(),now()),
        ('gostanford.com', 'http://gostanford.com/rss.aspx?path=msoc',now(),now()),
        ('gostanford.com', 'http://gostanford.com/rss.aspx?path=wbball',now(),now()),
        ('gostanford.com', 'http://gostanford.com/rss.aspx?path=bvball',now(),now()),
        ('gostanford.com', 'http://gostanford.com/rss.aspx?path=wvball',now(),now()),
        ('gostanford.com', 'http://gostanford.com/rss.aspx?path=xc',now(),now());");
    }
}
