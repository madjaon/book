<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Storage;

class UtilityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function clearallstorage()
    {
        \Artisan::call('cache:clear');
        \Artisan::call('view:clear');
        return back()->with('success', trans('titles.cleared'));
    }

    // SITEMAP
    
    public function gensitemap()
    {
        self::sitemap1();
        self::sitemap2();
        self::sitemap3();
        $msg = trans('titles.createSuccess') . ' Link sitemap.xml: ' . url('sitemap.xml');
        return back()->with('success', $msg);
    }

    private function sitemap1()
    {
        // $pages = self::getDataSitemap('pages');
        $posttypes = self::getDataSitemap('posttypes');
        $posttags = self::getDataSitemap('posttags');
        $postseries = self::getDataSitemap('postseries');

        // return view
        $content = view('utility.sitemap1', [
                // 'pages' => $pages,
                'posttypes' => $posttypes,
                'posttags' => $posttags,
                'postseries' => $postseries,
            ]);

        // encode gz sitemap content
        $filename = 'sitemap1.xml.gz';
        $gzdata = gzencode($content, 9);
        // $filepath = public_path().'/'.$filename;
        // $fp = fopen($filepath, "w");
        // fwrite($fp, $gzdata);
        // fclose($fp);
        Storage::disk('public')->put($filename, $gzdata);

        return $filename;
    }

    private function sitemap2()
    {
        $posts = self::getDataSitemap('posts');

        // return view
        $content = view('utility.sitemap2', [
                'posts' => $posts,
            ]);

        // encode gz sitemap content
        $filename = 'sitemap2.xml.gz';
        $gzdata = gzencode($content, 9);
        // $filepath = public_path().'/'.$filename;
        // $fp = fopen($filepath, "w");
        // fwrite($fp, $gzdata);
        // fclose($fp);
        Storage::disk('public')->put($filename, $gzdata);

        return $filename;
    }

    private function sitemap3()
    {
        $take = 10000;
        $number = 3;
        $skip = 0;
        $check = TRUE;
        while($check === TRUE) {
            $postchaps = self::getDataSitemap('postchaps', ['slug', 'post_id', 'updated_at'], $take, $skip);
            if(count($postchaps) > 0) {
                // return view
                $content = view('utility.sitemap3', [
                        'postchaps' => $postchaps,
                    ]);

                // encode gz sitemap content
                $filename = 'sitemap'.$number.'.xml.gz';
                $gzdata = gzencode($content, 9);
                // $filepath = public_path().'/'.$filename;
                // $fp = fopen($filepath, "w");
                // fwrite($fp, $gzdata);
                // fclose($fp);
                Storage::disk('public')->put($filename, $gzdata);

                $number += 1;
                $skip += $take;
                $check = TRUE;
            } else {
                $check = FALSE;
            }
        }
        return 'sitemap3.xml.gz -> sitemap'.($number-1).'.xml.gz';
    }

    private function getDataSitemap($table, $fields = array('slug', 'updated_at'), $take = null, $skip = null)
    {
        $data = DB::table($table)->select($fields)->where('status', 1);
        if(isset($skip)) {
            $data = $data->skip($skip);
        }
        if(isset($take)) {
            $data = $data->take($take);
        }
        return $data->get();
    }

    // END SITEMAP


}
