<?php 
namespace App\Helpers;

class CommonMethod
{
	// show 0 for null
	static function getZero($number = null)
	{
		if(!empty($number)) {
			return $number;
		}
		return 0;
	}
	// build slug form name
	static function buildSlug($name = '')
	{
		$slug = self::convert_string_vi_to_en($name);
        $slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/i', '-', str_replace('.', '', rtrim($slug, '-'))));
        return $slug;
	}
	static function convert_string_vi_to_en($str)
	{
	    $unicode = array(
	        'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
	        'd'=>'đ',
	        'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
	        'i'=>'í|ì|ỉ|ĩ|ị',
	        'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
	        'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
	        'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
	        'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
	        'D'=>'Đ',
	        'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
	        'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
	        'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
	        'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
	        'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
	    );
	    foreach($unicode as $nonUnicode => $uni){
	        $str = preg_replace("/($uni)/i", $nonUnicode, $str);
	    }
	    return $str;
	}
	// cut domain form url
	static function removeDomainUrl($url)
	{
        $dm = url('/').'/';
        $output = str_replace($dm, '/', $url);
        return $output;
    }
	static function numberFormatDot($number)
	{
	    if (!empty($number) && $number > 0) {
	    	$text = number_format($number, 0, ",", ".");
	    } else {
	    	$text = 0;
	    }
	    return $text;
	}
	// typeThumb: null -> origin image (/images), 0 -> folder: /thumbs, 1 -> folder: images/thumb, 2 -> images/folder: thumb2, 3 -> folder: images/thumb3
	static function getThumbnail($imageUrl, $typeThumb = null)
	{
		if(!empty($imageUrl)) {
			// check image url has /thumb/ or not
			if(strpos($imageUrl, '/thumb/') !== false) {
				if($typeThumb === 0) {
					$thumbnail = str_replace('/images/', '/thumbs/', $imageUrl);
					$thumbnail = str_replace('/thumb/', '/', $thumbnail);
					return $thumbnail;
				} elseif($typeThumb == 1) {
					return $imageUrl;
				} elseif($typeThumb == 2) {
					$thumbnail = str_replace('/thumb/', '/thumb2/', $imageUrl);
					return $thumbnail;
				} elseif($typeThumb == 3) {
					$thumbnail = str_replace('/thumb/', '/thumb3/', $imageUrl);
					return $thumbnail;
				} else {
					$thumbnail = str_replace('/thumb/', '/', $imageUrl);
					return $thumbnail;
				}
    		} elseif(strpos($imageUrl, '/thumb2/') !== false) {
    			if($typeThumb === 0) {
					$thumbnail = str_replace('/images/', '/thumbs/', $imageUrl);
					$thumbnail = str_replace('/thumb2/', '/', $thumbnail);
					return $thumbnail;
				} elseif($typeThumb == 1) {
					$thumbnail = str_replace('/thumb2/', '/thumb/', $imageUrl);
					return $thumbnail;
				} elseif($typeThumb == 2) {
					return $imageUrl;
				} elseif($typeThumb == 3) {
					$thumbnail = str_replace('/thumb2/', '/thumb3/', $imageUrl);
					return $thumbnail;
				} else {
					$thumbnail = str_replace('/thumb2/', '/', $imageUrl);
					return $thumbnail;
				}
    		} elseif(strpos($imageUrl, '/thumb3/') !== false) {
    			if($typeThumb === 0) {
					$thumbnail = str_replace('/images/', '/thumbs/', $imageUrl);
					$thumbnail = str_replace('/thumb3/', '/', $thumbnail);
					return $thumbnail;
				} elseif($typeThumb == 1) {
					$thumbnail = str_replace('/thumb3/', '/thumb/', $imageUrl);
					return $thumbnail;
				} elseif($typeThumb == 2) {
					$thumbnail = str_replace('/thumb3/', '/thumb2/', $imageUrl);
					return $thumbnail;
				} elseif($typeThumb == 3) {
					return $imageUrl;
				} else {
					$thumbnail = str_replace('/thumb3/', '/', $imageUrl);
					return $thumbnail;
				}
    		} else {
    			$dirname = pathinfo($imageUrl, PATHINFO_DIRNAME);
				$basename = pathinfo($imageUrl, PATHINFO_BASENAME);
    			if($typeThumb === 0) {
					$thumbnail = str_replace('/images/', '/thumbs/', $imageUrl);
					return $thumbnail;
				} elseif($typeThumb == 1) {
        			$thumbnail = $dirname . '/thumb/' . $basename;
					return $thumbnail;
				} elseif($typeThumb == 2) {
					$thumbnail = $dirname . '/thumb2/' . $basename;
					return $thumbnail;
				} elseif($typeThumb == 3) {
					$thumbnail = $dirname . '/thumb3/' . $basename;
					return $thumbnail;
				} else {
					return $imageUrl;
				}
    		}

		} else {
			return '';
		}
		
	}

	// echo time_elapsed_string('2013-05-01 00:22:35');
	// echo time_elapsed_string('@1367367755'); # timestamp input
	// echo time_elapsed_string('2013-05-01 00:22:35', true);
	static function time_elapsed_string($datetime, $full = false) {
	    $now = new \DateTime;
	    $ago = new \DateTime($datetime);
	    $diff = $now->diff($ago);

	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => 'năm',
	        'm' => 'tháng',
	        'w' => 'tuần',
	        'd' => 'ngày',
	        'h' => 'giờ',
	        'i' => 'phút',
	        's' => 'giây',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            // $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
	        } else {
	            unset($string[$k]);
	        }
	    }

	    if (!$full) $string = array_slice($string, 0, 1);
	    return $string ? implode(', ', $string) . ' trước' : 'ngay bây giờ';
	}

	// CACHE FORGET
    static function forgetCache($cacheName)
    {
        // delete cache for contact page before redirect to remove message validator
        $cacheNameMobile = $cacheName.'_mobile';
        \Cache::forget($cacheName);
        \Cache::forget($cacheNameMobile);
    }

}