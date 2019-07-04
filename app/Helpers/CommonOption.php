<?php 
namespace App\Helpers;

class CommonOption
{
	//status
    static function statusArray()
    {
        return array(1=>trans('titles.statusEnabled'), 2=>trans('titles.statusDisabled'));
    }
    static function getStatus($key=1)
    {
    	$array = self::statusArray();
        if($key == 1) {
            // return '<span style="color: green;">'.$array[$key].'</span>';
            return '<span class="label label-success">'.$array[$key].'</span>';
        } else {
            // return '<span style="color: red;">'.$array[$key].'</span>';
            return '<span class="label label-danger">'.$array[$key].'</span>';
        }
    }
    //language
    static function langArray()
    {
        return array(LANG1=>'Tiếng việt'); //, LANG1=>'Tiếng việt', LANG2=>'Tiếng anh'
    }
    static function getLang($key=LANG1)
    {
    	$array = self::langArray();
        return $array[$key];
    }
    //menu
    static function menuTypeArray()
    {
        return array(
            1=>'Menu đầu trang', 
            2=>'Menu cột bên', 
            // 3=>'Menu cuối trang', 
            4=>'Menu mobile', 
        );
    }
    static function getMenuType($key=1)
    {
        $array = self::menuTypeArray();
        return $array[$key];
    }
    //kind
    static function kindArray()
    {
        return array(1=>trans('caption.complete'), 2=>trans('caption.continue'));
    }
    static function getKind($key=1)
    {
        $array = self::kindArray();
        return $array[$key];
    }
    //ads position
    static function positionArray()
    {
        return array(
            1 => 'Header - PC',
            2 => 'Header - Mobile',
            3 => 'Footer - PC',
            4 => 'Footer - Mobile',
            5 => 'Trôi bên trái - PC',
            6 => 'Trôi bên phải - PC',
            7 => 'Trên cột bên cạnh - PC',
            8 => 'Trên cột bên cạnh - Mobile',
            9 => 'Dưới cột bên cạnh - PC',
            10 => 'Dưới cột bên cạnh - Mobile',
            11 => 'Trên trang nội dung - PC',
            12 => 'Trên trang nội dung - Mobile',
            13 => 'Dưới trang nội dung - PC',
            14 => 'Dưới trang nội dung - Mobile',
            15 => 'Trên trang đọc truyện - PC',
            16 => 'Trên trang đọc truyện - Mobile',
            17 => 'Dưới trang đọc truyện - PC',
            18 => 'Dưới trang đọc truyện - Mobile',
            
        );
    }
    static function getPosition($key)
    {
        $array = self::positionArray();
        return $array[$key];
    }
    // year
    static function yearArray()
    {
        $data = array('0'=>'Không rõ');
        for($i = 2030; $i >= 1960; $i--) {
            $data[$i] = $i;
        }
        return $data;
    }
    static function getYear($key)
    {
        $array = self::yearArray();
        return $array[$key];
    }
    // nation
    static function nationArray()
    {
        return array(
            1 => 'Việt Nam',
            2 => 'Nhật Bản',
            3 => 'Trung Quốc',
            4 => 'Hàn Quốc',
            5 => 'Âu Mỹ',
            6 => 'Nước Khác',
            
        );
    }
    static function getNation($key=1)
    {
        $array = self::nationArray();
        return $array[$key];
    }
    // type
    static function typeArray()
    {
        return array(
            1 => 'Truyện Chữ',
            2 => 'Truyện Tranh',
            3 => 'Ảnh Đẹp',
            
        );
    }
    static function getType($key=1)
    {
        $array = self::typeArray();
        return $array[$key];
    }
}
