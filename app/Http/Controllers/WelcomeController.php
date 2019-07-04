<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\CommonOption;
use App\Helpers\CommonMethod;
use DB;
use Validator;
use App\Traits\CaptchaTrait;

class WelcomeController extends Controller
{

    use CaptchaTrait;

	public function __construct()
    {
        $this->sharedata();
    }

    // index
    public function welcome()
    {
    	$data = $this->getPosts()->take(PAGINATE)->get();

        // return view
        return view('site.index', ['data' => $data]);
    }

    // /slug
    public function page($slug)
    {
    	// IF SLUG IS A POST
        $rs = DB::table('posts')
            ->where('slug', $slug)
            ->where('status', 1)
            ->where('start_date', '<=', date('Y-m-d H:i:s'))
            ->first();
        // result
        if(isset($rs)) {
            // auto meta seo
            $rsName = mb_convert_case($rs->name, MB_CASE_TITLE, "UTF-8");
            $rs->h1 = $rsName;
            if(empty($rs->meta_title)) {
                $rs->meta_title = 'Đọc truyện ' . $rsName;
            }
            if(empty($rs->meta_keyword)) {
                $rs->meta_keyword = $rsName;
            }
            if(empty($rs->meta_description)) {
                $rs->meta_description = !empty($rs->summary)?str_limit($rs->summary, 300):$rsName;
            }
            if(empty($rs->meta_image)) {
                $rs->meta_image = DEFAULT_AVATAR;
            }

            // seri
            $seri = DB::table('postseries')
                    ->select('id', 'name', 'slug')
                    ->where('id', $rs->seri)
                    ->where('status', 1)
                    ->first();
            if(isset($seri)) {
                $rs->seriInfo = $seri;
                // seri data: danh sach thuoc seri nay
                $rs->seriData = $this->getPostBySeriQuery($rs->seri, $rs->id)->get();
            }

            // nation
            $rs->nationName = CommonOption::getNation($rs->nation);

            // tinh trang kind
            $rs->kindName = CommonOption::getKind($rs->kind);

            // list tags
            $tags = $this->getRelationsByPostQuery('tag', $rs->id);
            $rs->tags = $tags;

            // list type
            $types = $this->getRelationsByPostQuery('type', $rs->id);
            $rs->types = $types;

            // chapters list / use for list chapters in post
            $eps = $this->getChapsListByPostId($rs->id, 'asc')->take(PAGINATEBOX)->get();
            $rs->eps = $eps;

            // chapters list latest / use for list chapters in post
            // $epsLastest = $this->getChapsListByPostId($rs->id, 'desc')->take(PAGINATEBOX)->get();
            // $rs->epsLastest = $epsLastest;

            // first chapter
            // if use $eps: uncomment lines below
            if(count($eps) > 0) {
                $rs->epFirst = $eps[0];
            }
            // if use $eps: comment line below
            // $epFirst = $this->getChapsListByPostId($rs->id, 'asc')->first();
            // $rs->epFirst = $epFirst;

            // last chapter
            // if use $epsLastest: uncomment lines below
            // if(count($epsLastest) > 0) {
            //     $rs->epLast = $epsLastest[0];
            // }
            // if use $epsLastest: comment line below
            $epLast = $this->getChapsListByPostId($rs->id, 'desc')->first();
            $rs->epLast = $epLast;

            // USE FOR LOAD PAGE BOX

            $countEps = $this->countChapsListByPostId($rs->id);
            $totalPageEps = ceil($countEps / PAGINATEBOX);
            $currentPageEps = 1;
            $rs->countEps = $countEps;
            $rs->totalPageEps = $totalPageEps;
            $rs->currentPageEps = $currentPageEps;
            $rs->prevPageEps = ($currentPageEps > 1)?($currentPageEps - 1):null;
            $rs->nextPageEps = ($currentPageEps < $totalPageEps)?($currentPageEps + 1):null;

            // END USE FOR LOAD PAGE BOX

            // return view
            return view('site.post', ['rs' => $rs]);
        }
        return response()->view('errors.404', [], 404);
    }

    // /slug1/slug2
    public function page2($slug1, $slug2)
    {
    	// query
        // post
        $post = DB::table('posts')
            ->select('id', 'name', 'slug')
            ->where('slug', $slug1)
            ->where('status', 1)
            ->where('start_date', '<=', date('Y-m-d H:i:s'))
            ->first();
        if(isset($post)) {
            // current chap
            $rs = DB::table('postchaps')
                ->where('slug', $slug2)
                ->where('post_id', $post->id)
                ->where('status', 1)
                ->where('start_date', '<=', date('Y-m-d H:i:s'))
                ->first();
            if(isset($rs)) {

            	// auto meta seo
            	$postName = mb_convert_case($post->name, MB_CASE_TITLE, "UTF-8");
	            $rsName = mb_convert_case($rs->name, MB_CASE_TITLE, "UTF-8");
	            $rs->h1 = $postName . ' - ' . $rsName;
	            if(empty($rs->meta_title)) {
	                $rs->meta_title = 'Đọc truyện ' . $rs->h1;
	            }
	            if(empty($rs->meta_keyword)) {
	                $rs->meta_keyword = $rsName;
	            }
	            if(empty($rs->meta_description)) {
	                $rs->meta_description = !empty($rs->summary)?str_limit($rs->summary, 300):$rsName;
	            }
	            if(empty($rs->meta_image)) {
	                $rs->meta_image = DEFAULT_AVATAR;
	            }

                // list type
                $types = $this->getRelationsByPostQuery('type', $post->id);
                $post->types = $types;

                // chap list
                $eps = $this->getChapsListByPostId($post->id, 'asc')->get();

                // SELECT BOX CHAP
                $chapsArray = array();
                foreach($eps as $key => $value) {
                    $chapUrl = url($post->slug . '/' . $value->slug);
                    if($value->volume > 0) {
                      $chapter = 'Quyển ' . $value->volume . ' chương ' . $value->chapter;
                    } else {
                      $chapter = 'Chương ' . $value->chapter;
                    }
                    $chapsArray[$chapUrl] = $chapter;
                }
                $post->chapsArray = $chapsArray;

                // PREV & NEXT Chaps
                // Chaps dua vao position (bat buoc phai nhap dung position)
                $epPrev = $this->getChapsListByPostId($post->id, 'desc')->where('position', '<', $rs->position)->first();
                $epNext = $this->getChapsListByPostId($post->id, 'asc')->where('position', '>', $rs->position)->first();
                
                // gan gia tri vao $rs
                if(isset($epPrev)) {
                    $rs->epPrev = $epPrev;
                }
                if(isset($epNext)) {
                    $rs->epNext = $epNext;
                }
                // END PREV & NEXT Chaps

                // return view
                return response()->view('site.chapter', [
                        'post' => $post, 
                        'rs' => $rs, 
                    ]);
            }
        }
        return response()->view('errors.404', [], 404);
    }

    public function type(Request $request, $slug)
    {
    	// check page
        $page = ($request->page)?$request->page:1;

        // query
        $rs = DB::table('posttypes')
            ->select('id', 'name', 'slug', 'summary', 'content', 'image', 'meta_title', 'meta_keyword', 'meta_description', 'meta_image')
            ->where('slug', $slug)
            ->where('status', 1)
            ->first();
        // result
        if(isset($rs)) {
            $data = $this->getPostsByRelationQuery('type', $rs->id)->paginate(PAGINATE);
            // auto meta seo
            $rsName = mb_convert_case($rs->name, MB_CASE_TITLE, "UTF-8");
            $rs->h1 = 'Thể loại truyện ' . $rsName;
            if(empty($rs->meta_title)) {
                if($page > 1) {
                    $rs->meta_title = 'Đọc truyện thể loại ' . $rsName.' trang '.$page;
                } else {
                    $rs->meta_title = 'Đọc truyện thể loại ' . $rsName;
                }
            }
            if(empty($rs->meta_keyword)) {
                $rs->meta_keyword = $rsName;
            }
            if(empty($rs->meta_description)) {
                $rs->meta_description = !empty($rs->summary)?str_limit($rs->summary, 300):$rsName;
            }
            if(empty($rs->meta_image)) {
                $rs->meta_image = DEFAULT_AVATAR;
            }

            // return view
            return view('site.posts', ['data' => $data, 'rs' => $rs]);
        }
        return response()->view('errors.404', [], 404);
    }

    public function tag(Request $request, $slug)
    {
    	// check page
        $page = ($request->page)?$request->page:1;

        // query
        $rs = DB::table('posttags')
            ->select('id', 'name', 'slug', 'summary', 'content', 'image', 'meta_title', 'meta_keyword', 'meta_description', 'meta_image')
            ->where('slug', $slug)
            ->where('status', 1)
            ->first();
        // result
        if(isset($rs)) {
            $data = $this->getPostsByRelationQuery('tag', $rs->id)->paginate(PAGINATE);
            // auto meta seo
            $rsName = mb_convert_case($rs->name, MB_CASE_TITLE, "UTF-8");
            $rs->h1 = 'Truyện ' . $rsName;
            if(empty($rs->meta_title)) {
                if($page > 1) {
                    $rs->meta_title = 'Đọc truyện ' . $rsName .' trang '.$page;
                } else {
                    $rs->meta_title = 'Đọc truyện ' . $rsName;
                }
            }
            if(empty($rs->meta_keyword)) {
                $rs->meta_keyword = $rsName;
            }
            if(empty($rs->meta_description)) {
                $rs->meta_description = !empty($rs->summary)?str_limit($rs->summary, 300):$rsName;
            }
            if(empty($rs->meta_image)) {
                $rs->meta_image = DEFAULT_AVATAR;
            }

            // return view
            return view('site.posts', ['data' => $data, 'rs' => $rs]);
        }
        return response()->view('errors.404', [], 404);
    }

    public function seri(Request $request, $slug)
    {
    	// check page
        $page = ($request->page)?$request->page:1;

        // query
        $rs = DB::table('postseries')
            ->select('id', 'name', 'slug', 'summary', 'content', 'image', 'meta_title', 'meta_keyword', 'meta_description', 'meta_image')
            ->where('slug', $slug)
            ->where('status', 1)
            ->first();
        // result
        if(isset($rs)) {
            $data = $this->getPostBySeriQuery($rs->id)->paginate(PAGINATE);
            // auto meta seo
            $rsName = mb_convert_case($rs->name, MB_CASE_TITLE, "UTF-8");
            $rs->h1 = 'Chủ đề truyện ' . $rsName;
            if(empty($rs->meta_title)) {
                if($page > 1) {
                    $rs->meta_title = 'Đọc truyện ' . $rsName.' trang '.$page;
                } else {
                    $rs->meta_title = 'Đọc truyện ' . $rsName;
                }
            }
            if(empty($rs->meta_keyword)) {
                $rs->meta_keyword = $rsName;
            }
            if(empty($rs->meta_description)) {
                $rs->meta_description = !empty($rs->summary)?str_limit($rs->summary, 300):$rsName;
            }
            if(empty($rs->meta_image)) {
                $rs->meta_image = DEFAULT_AVATAR;
            }

            // return view
            return view('site.posts', ['data' => $data, 'rs' => $rs]);
        }
        return response()->view('errors.404', [], 404);
    }

    public function picture(Request $request)
    {
    	// check page
        $page = ($request->page)?$request->page:1;

        // auto meta seo
        $rs = new \stdClass();
        $rs->h1 = 'Ảnh Đẹp';
        if($page > 1) {
            $rs->meta_title = 'Ảnh đẹp ' . $rs->h1 .' trang '.$page;
        } else {
            $rs->meta_title = 'Ảnh đẹp ' . $rs->h1;
        }
        $rs->meta_keyword = $rs->h1;
        $rs->meta_description = $rs->h1;
        $rs->meta_image = DEFAULT_AVATAR;

        $rs->type = 3;

        // query
        $data = $this->getPosts()->where('type', 3)->paginate(PAGINATE);

        // return view
        return view('site.posts', ['data' => $data, 'rs' => $rs]);
    }

    public function manga(Request $request)
    {
    	// check page
        $page = ($request->page)?$request->page:1;

        // auto meta seo
        $rs = new \stdClass();
        $rs->h1 = 'Truyện Tranh';
        if($page > 1) {
            $rs->meta_title = 'Đọc truyện tranh ' . $rs->h1 .' trang '.$page;
        } else {
            $rs->meta_title = 'Đọc truyện tranh ' . $rs->h1;
        }
        $rs->meta_keyword = $rs->h1;
        $rs->meta_description = $rs->h1;
        $rs->meta_image = DEFAULT_AVATAR;

        $rs->type = 2;

        // query
        $data = $this->getPosts()->where('type', 2)->paginate(PAGINATE);

        // return view
        return view('site.posts', ['data' => $data, 'rs' => $rs]);
    }

    public function search(Request $request)
    {
    	// check page
        $page = ($request->page)?$request->page:1;

        // auto meta tag for seo
        $rs = new \stdClass();
        $rs->h1 = 'Kết quả tìm kiếm ' . $request->s;
        if($page > 1) {
            $rs->meta_title = 'Kết quả tìm kiếm ' . $request->s . ' trang ' . $page;
        } else {
            $rs->meta_title = 'Kết quả tìm kiếm ' . $request->s;
        }
        $rs->meta_keyword = 'tìm truyện ' . $request->s . ', tim truyen ' . $request->s;
        $rs->meta_description = 'Kết quả tìm kiếm từ khóa ' . $request->s . ', tìm truyện ' . $request->s;
        $rs->meta_image = DEFAULT_AVATAR;

        if($request->s == '' || strlen($request->s) < 2 || strlen($request->s) > 255) {
            return view('site.posts', ['data' => null, 'rs' => $rs, 'request' => $request]);
        }
        
        // query
        $data = $this->searchQuery($request->s)->paginate(PAGINATE);

        // return view
        return view('site.posts', ['data' => $data->appends($request->except('page')), 'rs' => $rs, 'request' => $request]);
    }

    public function livesearch(Request $request)
    {
    	if($request->s == '' || strlen($request->s) < 2 || strlen($request->s) > 255) {
            return null;
        }
        
        $array = array();
        // AJAX SEARCH
        $data = $this->searchQuery($request->s)->take(PAGINATEBOX)->get();

        if(count($data) > 0) {
            foreach($data as $value) {
                $array[] = [
                    'suggestion' => '<span class="poies">'.$value->name.'</span>',
                    'url' => url($value->slug),
                    // "attr" => [["class" => "suggestion"]]
                ];
            }
        }

        $res = ['results' => $array];
        
        return response()->json($res);
    }

    public function sitemap()
    {
        $sitemaps = array();
        foreach (glob('storage/*.xml.gz') as $filename) {
            array_push($sitemaps, url($filename));
        }
        // return view
        $content = view('site.sitemap', ['sitemaps' => $sitemaps]);
        return response($content)->header('Content-Type', 'text/xml;charset=utf-8');
    }

    public function contact()
    {
        return view('site.contact');
    }

    public function send(Request $request)
    {
        // check recaptcha
        $data['captcha'] = $this->captchaCheck();

        if (!config('settings.reCaptchStatus')) {
            $data['captcha'] = true;
        }

        $request->request->add(['captcha' => $data['captcha']]);

        //
        $validator = Validator::make($request->all(),
            [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255',
                'msg' => 'required|max:1000',
                'g-recaptcha-response'  => '',
                'captcha'               => 'required|min:1',
            ],
            [
                'name.required' => trans('validation.fullnameRequired'),
                'name.max' => trans('validation.fullnameMax'),
                'email.required' => trans('validation.emailRequired'),
                'email.format' => trans('validation.emailFormat'),
                'email.max' => trans('validation.emailMax'),
                'msg.required' => trans('validation.msgRequired'),
                'msg.max' => trans('validation.msgMax'),
                'g-recaptcha-response.required' => trans('auth.captchaRequire'),
                'captcha.min'                   => trans('auth.CaptchaWrong'),
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // send mail

        // dd($request->ip());

        return redirect()->back()->with('success', trans('caption.sendsuccess'));
    }


    public function rating(Request $request)
    {
        $rating = ($request->rating)?$request->rating:1;
        $id = ($request->id)?$request->id:0;

        $res = [];
        
        $ratingCookieName = 'rating' . $id;
        if(isset($_COOKIE[$ratingCookieName])) {
            return response()->json($res);
        }

        // post
        $post = DB::table('posts')
            ->where('id', $id)
            ->where('status', 1)
            ->where('start_date', '<=', date('Y-m-d H:i:s'))
            ->first();
        if(isset($post)) {
        	
        	// if null to 0
        	$post->rating_value = isset($post->rating_value)?$post->rating_value:0;
        	$post->rating_count = isset($post->rating_count)?$post->rating_count:0;

            if($post->rating_value == 0) {
                $ratingValue = $rating;
            } else {
                $ratingValue = ($post->rating_value + $rating) / 2;
            }
            $ratingValue = round($ratingValue, 1, PHP_ROUND_HALF_UP);
            $ratingCount = $post->rating_count + 1;
            DB::table('posts')->where('id', $id)->update(['rating_value' => $ratingValue, 'rating_count' => $ratingCount]);
            $res = ['ratingValue' => $ratingValue, 'ratingCount' => $ratingCount];
            // cache of this post must clear
            $cacheName = '/' . $post->slug;
            CommonMethod::forgetCache($cacheName);
        }
        return response()->json($res);
    }

    public function paging(Request $request)
    {
        // check page
        $page = ($request->page)?$request->page:1;
        $id = ($request->id)?$request->id:0;

        // query
        $rs = DB::table('posts')
            ->where('id', $id)
            ->where('status', 1)
            ->where('start_date', '<=', date('Y-m-d H:i:s'))
            ->first();
        if(isset($rs)) {
            $countEps = $this->countChapsListByPostId($rs->id);
            $totalPageEps = ceil($countEps / PAGINATEBOX);
            $currentPageEps = ($page > 0 && $page <= $totalPageEps)?$page:1;
            $listPageEps = null;
            if($totalPageEps > 0) {
                for($i = 1; $i <= $totalPageEps; $i++) {
                    $listPageEps[$i] = 'Trang ' . $i;
                }
            }
            $rs->countEps = $countEps;
            $rs->totalPageEps = $totalPageEps;
            $rs->currentPageEps = $currentPageEps;
            $rs->listPageEps = $listPageEps;
            $rs->prevPageEps = ($currentPageEps > 1)?($currentPageEps - 1):null;
            $rs->nextPageEps = ($currentPageEps < $totalPageEps)?($currentPageEps + 1):null;

            // offset
            $offset = ($page - 1) * PAGINATEBOX;

            // chapters list
            $eps = $this->getChapsListByPostId($rs->id, 'asc')->skip($offset)->take(PAGINATEBOX)->get();
            $rs->eps = $eps;

            // return view
            return view('site.common.chapters', ['rs' => $rs]);
        }
        return '<p>Đang cập nhật</p>';
    }

    private function sharedata()
	{
        $config = DB::table('configs')->first();
        $config->meta_image = !empty($config->meta_image)?$config->meta_image:DEFAULT_AVATAR;
        view()->share('config', $config);

        // getMenuTypes
        view()->share('menutypes', self::getMenuTypes());
        // getMenuMobile
        view()->share('menumobile', self::getMenuMobile());
	}

	private static function getMenuMobile()
    {
        $string = '';
        $data = self::getTypes();
        if(count($data) > 0) {
            $string .= view('site.common.menumobile', ['data' => $data])->render();
        }
        return $string;
    }

	private function getMenuTypes()
    {
        $string = '';
        $data = self::getTypes();
        if(count($data) > 0) {
            $string .= view('site.common.menutypes', ['data' => $data])->render();
        }
        return $string;
    }

    private static function getTypes()
    {
        $data = DB::table('posttypes')
            ->select('id', 'name', 'slug')
            ->where('status', 1)
            ->orderBy('name', 'asc')
            ->get();
        return $data;
    }

    // search query
    // to full text search (mysql) working
    // my.ini (my.cnf) add after line [mysqld] before restart sql service: 
    // innodb_ft_min_token_size = 2
    // ft_min_word_len = 2
    // run: mysql> REPAIR TABLE tbl_name QUICK;
    // UNION 2 SELECT with paginate:
    // https://stackoverflow.com/questions/25338456/laravel-union-paginate-at-the-same-time
    // error: ...isn't in GROUP BY (SQL...
    // set config/database.php: 'strict' => false,
    // If this is set to true then it'll add the ONLY_FULL_GROUP_BY when querying.
    private function searchQuery($s)
    {
        // addslashes: xu ly chuoi gay loi cau lenh sql. 
        $s = '+'. str_replace(' ', ' +', addslashes(trim($s)));
        $data = DB::table('posts')
            ->leftJoin('posttagrelations', 'posts.id', '=', 'posttagrelations.post_id')
            ->leftJoin('posttags', 'posttagrelations.posttag_id', '=', 'posttags.id')
            ->select('posts.id', 'posts.name AS name', 'posts.slug AS slug', 'posts.summary AS summary', 'posts.image AS image', 'posts.seri', 'posts.nation', 'posts.kind', 'posts.view')
            ->where('posts.status', 1)
            ->where('posts.start_date', '<=', date('Y-m-d H:i:s'))
            ->whereRaw('MATCH('.env('DB_PREFIX').'posts.slug,'.env('DB_PREFIX').'posts.name) AGAINST ("'.$s.'" IN BOOLEAN MODE)')
            ->orWhereRaw('MATCH('.env('DB_PREFIX').'posttags.slug,'.env('DB_PREFIX').'posttags.name) AGAINST ("'.$s.'" IN BOOLEAN MODE)')
            ->groupBy('posts.id');
        return $data;
    }

    // list posts
    private function getPosts($orderBy = 'start_date', $orderSort = 'desc')
    {
        $data = DB::table('posts')
            ->select('id', 'name', 'slug',  'summary', 'image', 'seri', 'nation', 'kind', 'view')
            ->where('status', 1)
            ->where('start_date', '<=', date('Y-m-d H:i:s'))
            ->orderBy($orderBy, $orderSort);
        return $data;
    }

    // element: tag or type / id: id of tag or type
    private function getPostsByRelationQuery($element, $id, $orderBy = 'start_date', $orderSort = 'desc')
    {
        $data = DB::table('posts')
            ->join('post'.$element.'relations', 'posts.id', '=', 'post'.$element.'relations.post_id')
            ->select('posts.id', 'posts.name', 'posts.slug',  'posts.summary', 'posts.image', 'posts.seri', 'posts.nation','posts.kind', 'posts.view')
            ->where('post'.$element.'relations.post'.$element.'_id', $id)
            ->where('posts.status', 1)
            ->where('posts.start_date', '<=', date('Y-m-d H:i:s'))
            ->orderBy('posts.'.$orderBy, $orderSort);
        return $data;
    }

    // get post by seri field in posts table
    private function getPostBySeriQuery($id, $currentPostId = null)
    {
        $data = DB::table('posts')
            ->select('id', 'name', 'slug',  'summary', 'image', 'seri', 'nation', 'kind', 'view')
            ->where('seri', $id)
            ->where('status', 1)
            ->where('start_date', '<=', date('Y-m-d H:i:s'));
        if($currentPostId != null) {
            $data = $data->where('id', '!=', $currentPostId);
        }
        return $data;
    }

    // element: tag or type / id: id of post
    private function getRelationsByPostQuery($element, $id)
    {
        $data = DB::table('post'.$element.'s')
            ->join('post'.$element.'relations', 'post'.$element.'s.id', '=', 'post'.$element.'relations.post'.$element.'_id')
            ->select('post'.$element.'s.id', 'post'.$element.'s.name', 'post'.$element.'s.slug')
            ->where('post'.$element.'relations.post_id', $id)
            ->where('post'.$element.'s.status', 1)
            ->get();
        return $data;
    }

    // $id: $post_id
    private function getChapsListByPostId($id, $orderSort = 'desc')
    {
        $data = DB::table('postchaps')
                ->select('id', 'name', 'slug', 'volume', 'chapter', 'start_date')
                ->where('post_id', $id)
                ->where('status', 1)
                ->where('start_date', '<=', date('Y-m-d H:i:s'))
                ->orderByRaw(DB::raw("position = '0', position ".$orderSort));
        return $data;
    }

    private function countChapsListByPostId($id)
    {
        $data = DB::table('postchaps')
                ->where('post_id', $id)
                ->where('status', 1)
                ->where('start_date', '<=', date('Y-m-d H:i:s'))
                ->count();
        return $data;
    }

}
