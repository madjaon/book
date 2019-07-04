<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostType;
use App\Helpers\CommonMethod;
use Sunra\PhpSimple\HtmlDomParser;
use Image;
use Validator;
use File;

class CrawlerController extends Controller
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

	private function requestPattern()
    {
    	$request = new \stdClass();
        // 1: Lấy tin theo danh sách links posts
        // 2: Lấy tin theo danh sách posts trong chuyên mục
        $request->type = 2;
        // list posts links, (link) or (link1,link2,...)
        $request->post_links = '';
        // link category page (many posts)
        $request->category_link = 'https://giaitri.vnexpress.net/tin-tuc/phim';
        // link category page with paging, page number is [page_number]
        $request->category_page_link = '';
        // number page need crawl
        $request->category_page_number = '';
        // link posts in category page
        $request->category_post_link_pattern = 'section.sidebar_1 div.thumb_art a';
        // 1: Lấy ảnh avatar từ trang chi tiết
        // 2: Lấy ảnh avatar từ trang chuyên mục
        $request->image_check = 2;
        // image avatar
        $request->image_pattern = 'section.sidebar_1 div.thumb_art a.thumb_5x3 img';
        // subFolder. /images/image_dir...
        $request->image_dir = 'phim';
        // slider images
        $request->slide_pattern = '#productswrapper table td[align=center] img';
        // title in post page
        $request->title_pattern = 'section.sidebar_1 h1.title_news_detail';
        // summary in post page
        $request->summary_pattern = 'section.sidebar_1 h2.description';
        // description in post page
        $request->description_pattern = 'section.sidebar_1 article.content_detail';
        // delete content html tag
        $request->description_pattern_delete = 'div';
        // position for delete element html tag: (0,1...)
        $request->element_delete_positions = '';
        // delete element html tag: (p)
        $request->element_delete = '';
        // domain source
        $request->source = 'giaitri.vnexpress.net';
        $request->type_main_id = 1;
        $request->posttype_id = [1,12];
        $request->posttag_id = [2,5];
        return $request;
    }

    public function steal()
    {

    	$request = self::requestPattern();

    	// dd($request);

        if($request->type == 1) {
            if(!empty($request->post_links)) {
                $links = explode(',', $request->post_links);
                $result = self::stealPost($request, $links);
            }
        } else if($request->type == 2) {
            if(!empty($request->category_link)) {
                $cats = [$request->category_link];
            } else {
                $cats = array();
            }
            //check paging
            if(!empty($request->category_page_link) && !empty($request->category_page_number)) {
                for($i = 2; $i <= $request->category_page_number; $i++) {
                    $cats[] = str_replace('[page_number]', $i, $request->category_page_link);
                }
            }
            if(count($cats) > 0 && !empty($request->category_post_link_pattern)) {
                foreach($cats as $key => $value) {

                	$stringHtml = self::get_remote_data($value);
                    // get all link cat
                    $html = HtmlDomParser::str_get_html($stringHtml); // Create DOM from URL or file

                    // get all link cat
                    // $html = HtmlDomParser::file_get_html($value); // Create DOM from URL or file

                    // danh sach link bai
                    foreach($html->find($request->category_post_link_pattern) as $element) {
                        $links[$key][] = trim($element->href);
                        // $links[$key][] = self::addDomainLink(trim($element->href), $request->source);
                    }
                    // danh sach link anh avatar tuong ung
                    if(!empty($request->image_check) && $request->image_check == 2 && !empty($request->image_pattern)) {
                        foreach($html->find($request->image_pattern) as $element) {
                            // $images[$key][] = $element->src;
                            // $images[$key][] = str_replace('_180x108', '', $element->src);
                        	// $images[$key][] = self::addDomainLink($element->src, $request->source);

                        	// as vnexpress has lazyload
                            $attr = 'data-original';
                            $img = str_replace('_180x108', '', $element->$attr);
                            if(!empty($img)) {
                            	$images[$key][] = $img;
                            } else {
                            	$images[$key][] = str_replace('_180x108', '', $element->src);
                            }
                            
                        }
                    } else {
                        $images[$key] = [];
                    }
                    // dd($links[$key]);
                    $result = self::stealPost($request, $links[$key], $images[$key]);
                }
            }
        }

        return redirect('home')->with('success', trans('titles.createSuccess'));
    }

    private function stealPost($request, $links, $images=array())
    {
        if(count($links) > 0) {
            foreach($links as $key => $link) {
                // if($key > 0) {

            	$stringHtml = self::get_remote_data($link);
                $html = HtmlDomParser::str_get_html($stringHtml); // Create DOM from URL or file

                // $html = HtmlDomParser::file_get_html($link); // Create DOM from URL or file

                // Lấy tiêu đề
                foreach($html->find($request->title_pattern) as $element) {
                    $postName = trim($element->plaintext); // Chỉ lấy phần text
                }

                // lay anh slide
                // foreach($html->find($request->slide_pattern) as $element) {
                //     if($element && !empty($element->src)) {
                //         // $srcimage = $element->src;
                //         // $srcimage = str_replace('-180x180', '', $element->src);
                //         $srcimage = self::addDomainLink($element->src, $request->source);
                //         //origin image upload
                //         $post_images[$key][] = self::uploadImage($srcimage, $request->image_dir);
                //     }
                // }
                
                // Lấy noi dung
                foreach($html->find($request->description_pattern) as $element) {
                    // tim anh avatar truoc khi xoa the chua anh <img>
                    if(!empty($request->image_check) && $request->image_check == 1 && !empty($request->image_pattern)) {
                        foreach($element->find($request->image_pattern) as $e) {
                            $images = [$e->src];
                        }
                    }
                    // Xóa các mẫu trong miêu tả
                    if(!empty($request->description_pattern_delete)) {
                        $arr = explode(',', $request->description_pattern_delete);
                        for($i=0;$i<count($arr);$i++) {
                            foreach($element->find($arr[$i]) as $e) {
                                $e->outertext='';
                            }
                        }
                    }
                    // loai bo the cu the element_delete
                    if(!empty($request->element_delete_positions) && !empty($request->element_delete)) {
                        $element_delete_positions = explode(',', $request->element_delete_positions);
                        if(count($element_delete_positions) > 0) {
                            foreach($element_delete_positions as $edp) {
                                $element->find($request->element_delete, $edp)->outertext='';
                            }
                        }
                    }
                    //neu khong xoa img trong noi dung thi can thay doi duong dan va upload hinh
                    if(empty($request->description_pattern_delete) || (!empty($request->description_pattern_delete) && strpos($request->description_pattern_delete, ',img') === false)) {
                        foreach($element->find('img') as $el) {
                            if($el && !empty($el->src)) {
                                $srcimage = $el->src;
                                // $srcimage = self::addDomainLink($el->src, $request->source);
                                //origin image upload
                                $el_src = self::uploadImage($srcimage, $request->image_dir);
                                //neu up duoc hinh thi thay doi duong dan, neu khong xoa the img nay di luon
                                if(!empty($el_src)) {
                                    $el->src = $el_src;
                                } else {
                                    $el->outertext = '';
                                }
                            }
                        }
                    }
                    $postDescription = trim($element->innertext); // Lấy toàn bộ phần html
                    //loai bo het duong dan trong noi dung
                    if(!empty($postDescription)) {
                        $postDescription = str_replace('<h1', '<p', $postDescription);
                        $postDescription = str_replace('</h1>', '</p>', $postDescription);
                        $postDescription = preg_replace('/style=\"(.*?)\"/', "", $postDescription);
                        $postDescription = preg_replace('/lang=\"(.*?)\"/', "", $postDescription);
                        $postDescription = preg_replace('/id=\"(.*?)\"/', "", $postDescription);
                        $postDescription = preg_replace('/class=\"(.*?)\"/', "", $postDescription);
                        $postDescription = preg_replace('/width=\"(.*?)\"/', "", $postDescription);
                        $postDescription = preg_replace('/height=\"(.*?)\"/', "", $postDescription);
                        $postDescription = preg_replace('/srcset=\"(.*?)\"/', "", $postDescription);
                        $postDescription = preg_replace('/sizes=\"(.*?)\"/', "", $postDescription);
                        $postDescription = preg_replace('/data-width=\"(.*?)\"/', "", $postDescription);
                        $postDescription = preg_replace('/data-pwidth=\"(.*?)\"/', "", $postDescription);
                        $postDescription = preg_replace('/data-was-processed=\"(.*?)\"/', "", $postDescription);
                        $postDescription = preg_replace('/<a href=\"(.*?)\">(.*?)<\/a>/', "\\2", $postDescription);
                        $postDescription = str_replace('<span >', '', $postDescription);
                        $postDescription = str_replace('</span>', '', $postDescription);
                        $postDescription = str_replace('<sup>', '', $postDescription);
                        $postDescription = str_replace('</sup>', '', $postDescription);
                        $postDescription = str_replace('<br>', '', $postDescription);
                        // remove all tag allow this
                        // $postDescription = strip_tags($postDescription, '<p>');
                    }
                }

                // Lấy mo ta ngan
                foreach($html->find($request->summary_pattern) as $element) {
                    $postSummary = trim($element->innertext);
                }
                // Neu khong co mo ta ngan thi lay theo description
                // $postSummary = str_limit(strip_tags($postDescription), 300);
                
                //upload images
                if(count($images) > 0) {
                    $image = self::uploadImage($images[$key], $request->image_dir, 1);
                } else {
                	$image = NULL;
                }

                //insert post
                $data = Post::create([
                    'name' => $postName,
                    'slug' => CommonMethod::buildSlug($postName),
                    'type_main_id' => $request->type_main_id,
                    'type' => 1, // 1:truyen chu,2:truyen tranh,3:anh dep
                    'summary' => !empty($postSummary)?$postSummary:'',
                    'content' => $postDescription,
                    'image' => $image,
                    // 'images' => implode(',', $post_images[$key]),
                    'start_date' => date('Y-m-d H:i:s'),
                ]);
                if(!empty($data)) {
                    // insert post type relation
                    if(count($request->posttype_id) > 0) {
                    	$data->posttypes()->attach($request->posttype_id);
                    }
		            // insert post tag relation
		            if(count($request->posttag_id) > 0) {
		            	$data->posttags()->attach($request->posttag_id);
		            }
                }
                
            // } // endif for check $key
            }
        }
        return 1;
    }

    private function addDomainLink($url, $domain) {
    	return 'http://' . $domain . str_replace(' ', '%20', $url);
    }

    // create thumbnail, upload, resize, watermark
    // imageUrl is full url (with http://...)
    // subFolder in parent folder (/images/subFolder/...)
    // result: null(origin images/)/ 0(thumbs/)/ 1(images/thumb)/ 2(images/thumb2)/ 3(images/thumb3)
	private function uploadImage($imageUrl, $subFolder, $result = null) {

		// ten anh co dau tieng viet gay loi khi upload. nen dung urlencode de xu ly
		$imageUrl = substr($imageUrl, 0, strrpos($imageUrl, '/') + 1) . urlencode(str_replace('/', '', substr($imageUrl, strrpos($imageUrl, '/'))));

		// mot so truong hop ten anh co dau cach %20 bi bien thanh %2520 nen xu ly:
		$imageUrl = str_replace('%2520', '%20', $imageUrl);

		/////////////////
		// make result //
		/////////////////

		//get image name: foo.jpg
        $name = basename($imageUrl);
        //change file name
        $filename = pathinfo($name, PATHINFO_FILENAME);
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $filename = str_replace('%20', '-', $filename);
		$filename = CommonMethod::buildSlug($filename);
        $name = $filename . '.' . $extension;

        //result path
        $imageResult = '/storage/images/'.$subFolder.'/'.$name;
        $imageResult0 = '/storage/thumbs/'.$name;
        $imageResult1 = '/storage/images/'.$subFolder.'/thumb/'.$name;
        $imageResult2 = '/storage/images/'.$subFolder.'/thumb2/'.$name;
        $imageResult3 = '/storage/images/'.$subFolder.'/thumb3/'.$name;

        //if non exist image then upload
        if(!file_exists(public_path().$imageResult) && !file_exists(public_path().$imageResult1) && !file_exists(public_path().$imageResult2) && !file_exists(public_path().$imageResult3)) {
	    	
	    	//directory to save
		    $directory = './storage/images/'.$subFolder;
		    $directory1 = './storage/images/'.$subFolder.'/thumb';
		    $directory2 = './storage/images/'.$subFolder.'/thumb2';
		    $directory3 = './storage/images/'.$subFolder.'/thumb3';

		    //check directory and create it if no exists
            File::makeDirectory($directory, $mode = 0755, true, true);
            File::makeDirectory($directory1, $mode = 0755, true, true);
            File::makeDirectory($directory2, $mode = 0755, true, true);
            File::makeDirectory($directory3, $mode = 0755, true, true);

	        self::uploadAction($imageUrl, $imageResult);
	        self::uploadAction($imageUrl, $imageResult0, 122, 91);
	        self::uploadAction($imageUrl, $imageResult1, SIZE_WIDTH, SIZE_HEIGHT);
	        self::uploadAction($imageUrl, $imageResult2, SIZE_WIDTH_2, SIZE_HEIGHT_2);
	        self::uploadAction($imageUrl, $imageResult3, SIZE_WIDTH_3, SIZE_HEIGHT_3);

	    }

	    if($result === 0) {
	    	return $imageResult0;
	    } elseif($result == 1) {
	    	return $imageResult1;
	    } elseif($result == 2) {
	    	return $imageResult2;
	    } elseif($result == 3) {
	    	return $imageResult3;
	    } else {
	    	return $imageResult;
	    }

	}

	private function uploadAction($imageUrl, $imageResult, $width = null, $height = null)
	{
		$mode = null;
		// open an image file
        try {
        	ini_set('memory_limit','256M');
        	ini_set('max_execution_time', 300);
        	$img = Image::make($imageUrl);
	        if(isset($width) && isset($height)) {
	        	//mode = resize / crop / fit ... more please go to page http://image.intervention.io/
	        	if($mode == 'resize') {
	        		// resize image instance
	        		$img->resize($width, $height);
	        	} else if($mode == 'crop') {
	        		// crop image
					$img->crop($width, $height);
	        	} else {
	        		if($width != $height) {
	        			// crop the best fitting 5:3 (600x360) ratio and resize to 600x360 pixel
						$img->fit($width, $height);
	        		} else {
	        			// crop the best fitting 1:1 ratio (200x200) and resize to 200x200 pixel
						$img->fit($width);
	        		}
	        	}
	        }
	    	// save image in desired format
	        $img->save(public_path().$imageResult);
	        return $imageResult;
        } catch (\Intervention\Image\Exception\NotReadableException $e) {
			return '';
		}
	}

    private function get_remote_data($url, $post_paramtrs=false, $return_full_array=false) {

        // $_SERVER['REMOTE_ADDR'] = isset($_SERVER['HTTP_CF_CONNECTING_IP']) ? $_SERVER['HTTP_CF_CONNECTING_IP'] : $_SERVER['REMOTE_ADDR'];

        $c = curl_init();curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        //if parameters were passed to this function, then transform into POST method.. (if you need GET request, then simply change the passed URL)
        if($post_paramtrs){curl_setopt($c, CURLOPT_POST,TRUE);  curl_setopt($c, CURLOPT_POSTFIELDS, "var1=bla&".$post_paramtrs );}
        curl_setopt($c, CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($c, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:33.0) Gecko/20100101 Firefox/33.0");
        curl_setopt($c, CURLOPT_COOKIE, '');
        //We'd better to use the above command, because the following command gave some weird STATUS results..
        // $header[0]= $user_agent="User-Agent: Mozilla/5.0 (Windows NT 6.1; rv:33.0) Gecko/20100101 Firefox/33.0";  $header[]="Cookie:CookieName1=Value;"; $header[]="Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5";  $header[]="Cache-Control: max-age=0"; $header[]="Connection: keep-alive"; $header[]="Keep-Alive: 300"; $header[]="Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7"; $header[] = "Accept-Language: en-us,en;q=0.5"; $header[] = "Pragma: ";  curl_setopt($c, CURLOPT_HEADER, true);     curl_setopt($c, CURLOPT_HTTPHEADER, $header);

        curl_setopt($c, CURLOPT_MAXREDIRS, 10);
        //if SAFE_MODE or OPEN_BASEDIR is set,then FollowLocation cant be used.. so...
        $follow_allowed= ( ini_get('open_basedir') || ini_get('safe_mode')) ? false:true;  if ($follow_allowed){curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);}
        curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 9);
        curl_setopt($c, CURLOPT_REFERER, $url);
        curl_setopt($c, CURLOPT_TIMEOUT, 600);
        curl_setopt($c, CURLOPT_AUTOREFERER, true);
        curl_setopt($c, CURLOPT_ENCODING, 'gzip,deflate');
        $data=curl_exec($c);$status=curl_getinfo($c);curl_close($c);
        
        preg_match('/(http(|s)):\/\/(.*?)\/(.*\/|)/si',  $status['url'],$link);
        //correct assets URLs(i.e. retrieved url is: http://site.com/DIR/SUBDIR/page.html... then href="./image.JPG" becomes href="http://site.com/DIR/SUBDIR/image.JPG", but  href="/image.JPG" needs to become href="http://site.com/image.JPG")
        
        //inside all links(except starting with HTTP,javascript:,HTTPS,//,/ ) insert that current DIRECTORY url (href="./image.JPG" becomes href="http://site.com/DIR/SUBDIR/image.JPG")
        $data=preg_replace('/(src|href|action)=(\'|\")((?!(http|https|javascript:|\/\/|\/)).*?)(\'|\")/si','$1=$2'.$link[0].'$3$4$5', $data);
        //inside all links(except starting with HTTP,javascript:,HTTPS,//)    insert that DOMAIN url (href="/image.JPG" becomes href="http://site.com/image.JPG")
        $data=preg_replace('/(src|href|action)=(\'|\")((?!(http|https|javascript:|\/\/)).*?)(\'|\")/si','$1=$2'.$link[1].'://'.$link[3].'$3$4$5', $data);
        // if redirected, then get that redirected page
        if($status['http_code']==301 || $status['http_code']==302) {
            //if we FOLLOWLOCATION was not allowed, then re-get REDIRECTED URL
            //p.s. WE dont need "else", because if FOLLOWLOCATION was allowed, then we wouldnt have come to this place, because 301 could already auto-followed by curl  :)
            if (!$follow_allowed){
                //if REDIRECT URL is found in HEADER
                if(empty($redirURL)){if(!empty($status['redirect_url'])){$redirURL=$status['redirect_url'];}}
                //if REDIRECT URL is found in RESPONSE
                if(empty($redirURL)){preg_match('/(Location:|URI:)(.*?)(\r|\n)/si', $data, $m);
                if (!empty($m[2])){ $redirURL=$m[2]; } }
                //if REDIRECT URL is found in OUTPUT
                if(empty($redirURL)){preg_match('/moved\s\<a(.*?)href\=\"(.*?)\"(.*?)here\<\/a\>/si',$data,$m); if (!empty($m[1])){ $redirURL=$m[1]; } }
                //if URL found, then re-use this function again, for the found url
                if(!empty($redirURL)){$t=debug_backtrace(); return call_user_func( $t[0]["function"], trim($redirURL), $post_paramtrs);}
            }
        }
        // if not redirected,and nor "status 200" page, then error..
        elseif ( $status['http_code'] != 200 ) { $data =  "ERRORCODE22 with $url<br/><br/>Last status codes:".json_encode($status)."<br/><br/>Last data got:$data";}
        return ( $return_full_array ? array('data'=>$data,'info'=>$status) : $data);
    }

    public function uploadImages()
    {
    	return view('utility.uploads');
    }

    public function uploadImagesAction(Request $request)
    {
    	$validator = Validator::make($request->all(),
            [
            	'folder'	=> 'required',
	            'urls'		=> 'required',
            ]
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $urls = explode("\r\n", $request->urls);

        if(count($urls) > 0) {
        	foreach($urls as $value) {
        		self::uploadImage(trim($value), $request->folder);
        	}
        }

        return back()->with('success', trans('titles.createSuccess'));
    }

}
