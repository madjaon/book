<?php 
namespace App\Helpers;

use DB;

class CommonQuery
{
    static function getAllFields($table, $id, $fields)
    {
        $data = DB::table($table)->select($fields)->where('id', $id)->first();
        if(!empty($data)) {
            return $data;
        }
        return null;
    }
    static function getAllIdName($table, $status = 1, $orderByPosition = null)
    {
        $data = DB::table($table)->select('id', 'name')->where('status', $status);
        if($orderByPosition != null) {
            $data = $data->orderByRaw(DB::raw("position = '0', position"))->get();
        } else {
            $data = $data->get();
        }
        if(!empty($data)) {
            return $data;
        }
        return null;
    }
    static function getAllWithStatus($table, $status = 1, $orderByPosition = null)
    {
        $data = DB::table($table)->where('status', $status);
        if($orderByPosition != null) {
            $data = $data->orderByRaw(DB::raw("position = '0', position"))->get();
        } else {
            $data = $data->get();
        }
        if(!empty($data)) {
            return $data;
        }
        return null;
    }
    static function getArrayWithStatus($table, $status = 1)
    {
        $data = DB::table($table)->where('status', $status);
        $data = $data->pluck('name', 'id');
        if(!empty($data)) {
            return $data;
        }
        return null;
    }
    static function getFieldById($table, $id, $field, $fieldIsNumber = null)
    {
        $data = DB::table($table)->where('id', $id);
        $data = $data->first();
        if(isset($data)) {
            return $data->$field;
        }
        if(isset($fieldIsNumber)) {
            return 0;
        }
        return '';
    }
    static function getAdByPosition($position=null)
    {
        if($position == null) {
            return '';
        }
        $data = DB::table('ads')
            ->where('position', $position)
            ->where('status', 1)
            ->first();
        if(isset($data)) {
            return '<div class="text-center">'.$data->code.'</div>';
        }
        return '';
    }
    static function checkAdByPosition($position=null)
    {
        if($position == null) {
            return false;
        }
        $data = DB::table('ads')
            ->where('position', $position)
            ->where('status', 1)
            ->first();
        if(isset($data)) {
            return true;
        }
        return false;
    }
    static function getArrayParentZero($table, $currentId=0)
    {
        $data = DB::table($table)
            ->select('id', 'name', 'parent_id')
            ->where('status', 1)
            ->where('parent_id', 0)
            ->where('id', '!=', $currentId);
        $data = $data->pluck('name', 'id');
        $firstValue = ($currentId!=0)?0:'';
        return array_add($data, $firstValue, '-- Chọn');
    }
    static function getArrayWithParent($table, $currentId=0)
    {
        $data = DB::table($table)
            ->select('id', 'name', 'parent_id')
            ->where('status', 1)
            ->where('id', '!=', $currentId);
        $data = $data->get();
        $firstValue = ($currentId!=0)?0:'';
        $output = self::_visit($data);
        return array_add($output, $firstValue, '-- Chọn');
    }
    static function _visit($data, $parentId=0, $prefix='')
    {
        $output = [];
        $current = self::_current($data, $parentId);
        $sub = self::_sub($data, $parentId);
        if(isset($current)) {
            $output[$current->id] = $prefix . $current->name;
            $prefix .= '-- ';
        }
        if(count($sub) > 0) {
            foreach($sub as $value) {
                $o = self::_visit($data, $value->id, $prefix);
                foreach($o as $k => $v) {
                    $output[$k] = $v;
                }
            }
        }
        return $output;
    }
    private static function _current($data, $parentId)
    {
        if(isset($data)) {
            foreach($data as $value) {
                if ($value->id == $parentId) {return $value;}
            }
        }
        return null;
    }
    private static function _sub($data, $parentId)
    {
        $sub = array();
        if(isset($data)) {
            foreach($data as $key => $value) {
                if ($value->parent_id == $parentId) {$sub[$key] = $value;}
            }
        }
        return $sub;
    }
    /**
    // check current menu
    // check menu parent, children, post
    **/
    static function checkCurrent($url, $home=null)
    {
        $currentUrl = request()->url();
        //check currentUrl post or type. follow menu table
        //1. get slug from currentUrl
        $uri = substr(strrchr($url, "/"), 1);
        $slug = substr(strrchr($currentUrl, "/"), 1);
        $slugs = array();
        $urls = array();
        //2. find all slug
        $type = DB::table('posttypes')->select('parent_id')->where('slug', $slug)->where('status', 1)->first();
        if(isset($type) && isset($type->parent_id)) {
            $slugs[] = $slug;
            $parent_id = $type->parent_id;
            while($parent_id <> 0) {
                $ps = self::findType($parent_id);
                if(!empty($ps)) {
                    $slugs[] = $ps[1];
                }
                $parent_id = $ps[0];
            }
        } else {
            $post = DB::table('posts')->select('type_main_id')->where('slug', $slug)->where('status', 1)->first();
            if(isset($post) && isset($post->type_main_id)) {
                $slugs[] = $slug;
                $parent_id = $post->type_main_id;
                while($parent_id <> 0) {
                    $ps = self::findType($parent_id);
                    if(!empty($ps)) {
                        $slugs[] = $ps[1];
                        $parent_id = $ps[0];
                    } else {
                        break;
                    }
                }
            }
        }
        //3. find menu - url = / + slug
        $slugs = array_unique($slugs);
        if(count($slugs) > 0) {
            foreach($slugs as $key => $value) {
                $menu = DB::table('menus')->select('parent_id', 'url')->where('url', '/'.$value)->where('status', 1)->first();
                if(isset($menu) && isset($menu->parent_id)) {
                    $urls[] = $menu->url;
                    $parent_id = $menu->parent_id;
                    while($parent_id <> 0) {
                        $pu = self::findMenu($parent_id);
                        if(!empty($pu)) {
                            $urls[] = $pu[1];
                            $parent_id = $pu[0];
                        } else {
                            break;
                        }
                    }
                }
            }
        }
        $urls = array_unique($urls);
        if(in_array('/'.$uri, $urls)) {
            return 'current';
        }
        return;
    }
    static function findType($parent_id)
    {
        $type = DB::table('posttypes')->select('parent_id', 'slug')->where('id', $parent_id)->where('status', 1)->first();
        if(isset($type) && isset($type->parent_id)) {
            return [$type->parent_id, $type->slug];
        }
        return;
    }
    static function findMenu($parent_id)
    {
        $menu = DB::table('menus')->select('parent_id', 'url')->where('id', $parent_id)->where('status', 1)->first();
        if(isset($menu) && isset($menu->parent_id)) {
            return [$menu->parent_id, $menu->url];
        }
        return;
    }
    // get 1 field array
    static function getArrayField($table, $field)
    {
        $data = DB::table($table)->select($field)->groupBy($field)->lists($field, $field);
        if(!empty($data)) {
            return $data;
        }
        return null;
    }

    // Create & Edit POST 
    static function issetPostType($postId, $postTypeId)
    {
        $count = DB::table('posttyperelations')
            ->where('post_id', $postId)
            ->where('posttype_id', $postTypeId)
            ->count();
        if($count > 0) {
            return true;
        }
        return false;
    }
    static function postTypeChecked($currentPostTypeId, $postTypeId)
    {
        // collection check
        // if($currentPostTypeId->search($postTypeId, true) !== false) {
        //     return 'checked="checked"';
        // }
        // array check
        if(in_array($postTypeId, $currentPostTypeId) !== false) {
            return 'checked="checked"';
        }
        return '';
    }
    //check type box
    static function postTypeMakeDisplay($postId, $makeId, $postTypeId, $issetCheck = true)
    {
        if($issetCheck == true) {
            $check = self::issetPostType($postId, $postTypeId);
            if($check == true && $makeId != $postTypeId) {
                return '';
            }
        } else {
            if($makeId != $postTypeId) {
                return '';
            }
        }
        return 'display: none;';
    }
    static function postTypeCheckedDisplay($makeId, $postTypeId)
    {
        if($makeId == $postTypeId) {
            return '';
        }
        return 'display: none;';
    }
    static function getArrayPostRelationId($postId, $relation = null)
    {
        if($relation == null) {
            $table = 'posttyperelations';
            $field = 'posttype_id';
        } else {
            $table = 'posttagrelations';
            $field = 'posttag_id';
        }
        $data = DB::table($table)
            ->where('post_id', $postId)
            ->pluck($field);
        if(!empty($data)) {
            return $data->toArray();
        }
        return [];
    }

}