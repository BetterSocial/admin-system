<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NewsLink;
use App\Models\Domain;
use DB;
use Illuminate\Support\Facades\Log;
use DOMDocument;

class NewsController extends Controller
{


    function readAsJson(Request $req)
    {
        
        //$url = "https://news.detik.com/berita/d-5578877/eks-menkes-siti-fadilah-puji-terawan-mundur-dari-pencalonan-dubes";
        $url = $req->url;
       
        $parse = parse_url($url);
        $domain = $parse['host'];

        $findDomain = Domain::where('domain_name', $domain )->first();
        $findNewsLink = NewsLink::where('news_url',$url)->first();

        if (empty($findNewsLink))
        {

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

            $HTML_DOCUMENT = curl_exec($ch);
            curl_close($ch);
            $internalErrors = libxml_use_internal_errors(true);
            $doc = new DOMDocument();
            $doc->loadHTML($HTML_DOCUMENT);
            libxml_use_internal_errors($internalErrors);
            // fecth <title>
            $res['title'] = $doc->getElementsByTagName('title')->item(0)->nodeValue;

            // fetch og:tags

            foreach ($doc->getElementsByTagName('meta') as $m) {

                // if had property
                if ($m->getAttribute('property')) {

                    //$prop = $m->getAttribute('property');

                    // here search only og:tags
                    if (substr($m->getAttribute('property'), 3) ==  'site_name') {
                        $res['site_name'] = $m->getAttribute('content');

                    }
                    if (substr($m->getAttribute('property'), 3) ==  'image') {
                        $res['image'] = $m->getAttribute('content');

                    }
                    if (substr($m->getAttribute('property'), 3) ==  'description') {
                        $res['description'] = $m->getAttribute('content');

                    }
                    if (substr($m->getAttribute('property'), 3) ==  'url') {
                        $res['url'] = $m->getAttribute('content');

                    }
                }
                // end if had property

                // fetch <meta name="description" ... >
                if ($m->getAttribute('name') == 'keywords') {

                    $res['keyword'] = $m->getAttribute('content');
                }
                if ($m->getAttribute('name') == 'author') {

                    $res['author'] = $m->getAttribute('content');
                }
            }
            // end foreach
            $newsLink = new NewsLink();
            $newsLink->domain_page_id =  $findDomain->domain_page_id;
            $newsLink->site_name = $res['site_name'];
            $newsLink->title =  $res['title'];
            $newsLink->image = $res['image'];
            $newsLink->description = $res['description'];
            $newsLink->url = $res['url'];
            $newsLink->keyword = $res['keyword'];
            $newsLink->author = $res['author'];
            $newsLink->news_url = $url;
            $newsLink->save();
            // render JSON
            // echo json_encode($res, JSON_PRETTY_PRINT |
            // JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        }

    }

    public function getData(Request $req){
        $columns = array(
            // datatable column index  => database column name
                0 => 'news_link_id',
                1 => 'news_url',
                2 => 'domain_page',
                3 => 'site_name',
                4 => 'title',
                5 => 'author',
                6 => 'keyword',
                7 => 'created_at',
            );
        $topic = "SELECT A.news_link_id,A.news_url,B.domain_name,A.site_name,A.title,A.author,A.keyword,A.created_at FROM news_link A 
        JOIN domain_page B ON A.domain_page_id = B.domain_page_id  WHERE true";
        if($req->siteName !=null){
            $topic .= " AND name ILIKE '%$req->name%'";
        }     
        if($req->title !=null){
            $topic .= " AND categories ILIKE '%$req->category%'";
        }    
        if($req->keyword !=null){
            $topic .= " AND categories ILIKE '%$req->category%'";
        }        
        

        $data = DB::SELECT($topic);
        $total = count($data);
        
        $topic .= " ORDER BY " . $columns[$req->order[0]['column']] . " " . $req->order[0]['dir'] . " LIMIT $req->length OFFSET $req->start ";
       
        $dataLimit = DB::SELECT($topic);
        return response()->json([
            'draw'            => $req->draw,
            'recordsTotal'    => $total,
            "recordsFiltered" => $total,
            'data'            => $dataLimit,
        ]);
    }
}
