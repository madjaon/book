<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Helpers\CommonMethod;
use Auth;
use Illuminate\Http\Request;
use Validator;
use DB;

class PostsController extends Controller
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

    private function validationMsg()
    {
    	return [
                'name.required'       	=> trans('validation.nameRequired'),
                'name.max'       	  	=> trans('validation.nameMax'),
                'slug.required'       	=> trans('validation.slugRequired'),
                'slug.max'       	  	=> trans('validation.slugMax'),
                'slug.unique' 		  	=> trans('validation.slugUnique'),
                'summary.max'         	=> trans('validation.summaryMax'),
                'image.max'         	=> trans('validation.imageMax'),
                'metaTitle.max'         => trans('validation.metaTitleMax'),
                'metaKeyword.max'       => trans('validation.metaKeywordMax'),
                'metaDescription.max'   => trans('validation.metaDescriptionMax'),
                'metaImage.max'         => trans('validation.metaImageMax'),
                // 'typeMainId.required'   => trans('validation.typeMainIdRequired'),
            ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!empty($request->issearch)) {
            $data = self::searchData($request);
        } else {
            $data = Post::orderBy('start_date', 'desc')->paginate(PAGINATION);
        }

        return view('posts.index', ['data' => $data, 'request' => $request]);
    }

    private function searchData($request)
    {
        $data = DB::table('posts')->where(function ($query) use ($request) {
            // condition
            if(!empty($request->keyword)) {
                $slug = CommonMethod::buildSlug($request->keyword);
                $query = $query->where('slug', 'like', '%'.$slug.'%');
                $query = $query->orWhere('name', 'like', '%'.$request->keyword.'%');
                $query = $query->orWhere('summary', 'like', '%'.$request->keyword.'%');
                $query = $query->orWhere('id', $request->keyword);
            }
            if(!empty($request->posttype_id)) {
                $listPostId = DB::table('posttyperelations')
                    ->where('posttype_id', $request->posttype_id)
                    ->pluck('post_id');
                $query = $query->whereIn('id', $listPostId);
            }
            if(!empty($request->seri)) {
                $query = $query->where('seri', $request->seri);
            }
            if(!empty($request->nation)) {
                $query = $query->where('nation', $request->nation);
            }
            if(!empty($request->kind)) {
                $query = $query->where('kind', $request->kind);
            }
            if(!empty($request->status)) {
                $query = $query->where('status', $request->status);
            }
            if(!empty($request->start_date)) {
                $query = $query->where('start_date', '>=', $request->start_date);
            }
            if(!empty($request->end_date)) {
                $query = $query->where('start_date', '<=', $request->end_date);
            }
        })
        ->orderBy('start_date', 'desc')
        ->paginate(PAGINATION);
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
            	'name' 				=> 'bail|required|max:191',
	            'slug' 				=> 'required|max:191|unique:posts',
	            'summary' 			=> 'max:500',
	            'image' 			=> 'max:191',
	            'meta_title' 		=> 'max:191',
	            'meta_keyword' 		=> 'max:191',
	            'meta_description' 	=> 'max:300',
	            'meta_image' 		=> 'max:191',
	            // 'type_main_id' 		=> 'required',
            ],
            self::validationMsg()
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        //images array remove last
        $images = $request->images;
        array_pop($images);
        $images = !empty($images)?implode(',', $images):'';
        if($images <> '') {
            //remove domain
            $images = str_replace(url('/').'/', '/', $images);
        }

        $post = Post::create([
            // 'name'             => $request->input('name'),
            // 'first_name'       => $request->input('first_name'),
            // 'last_name'        => $request->input('last_name'),
            // 'email'            => $request->input('email'),
            // 'password'         => bcrypt($request->input('password')),
            // 'token'            => str_random(64),
            // 'activated'        => 1,

            'name' => $request->name,
            'slug' => ($request->slug)?$request->slug:CommonMethod::buildSlug($request->name),
            'summary' => $request->summary,
            'content' => $request->content,
            'image' => CommonMethod::removeDomainUrl($request->image),
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'meta_image' => CommonMethod::removeDomainUrl($request->meta_image),
            'images' => $images,
            'type_main_id' => $request->type_main_id,
            'type' => $request->type,
            'seri' => $request->seri,
            'nation' => $request->nation,
            'kind' => $request->kind,
            'lang' => $request->lang,
            'status' => $request->status,
            'start_date' => ($request->start_date)?$request->start_date:date('Y-m-d H:i:s'),
        ]);

        if(!empty($post)) {
            // insert post type relation
            $post->posttypes()->attach($request->posttype_id);
            // insert post tag relation
            $post->posttags()->attach($request->posttag_id);
        }

        return redirect('posts')->with('success', trans('titles.createSuccess'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $data = Post::find($id);

        // return view('posts.show')->withUser($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Post::findOrFail($id);

        return view('posts.edit')->with(['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Post::find($id);

        $rules = [
            'name' 				=> 'bail|required|max:191',
            'summary' 			=> 'max:500',
            'image' 			=> 'max:191',
            'meta_title' 		=> 'max:191',
            'meta_keyword' 		=> 'max:191',
            'meta_description' 	=> 'max:300',
            'meta_image' 		=> 'max:191',
            // 'type_main_id' 		=> 'required',
        ];

        if($request->slug != $data->slug) {
            $rules['slug'] = 'required|max:191|unique:posts';
        }

        $validator = Validator::make($request->all(), $rules, self::validationMsg());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        //images array remove last
        $images = $request->images;
        array_pop($images);
        $images = !empty($images)?implode(',', $images):'';
        if($images <> '') {
            //remove domain
            $images = str_replace(url('/').'/', '/', $images);
        }

        $data->update([
            'name' => $request->name,
            'slug' => ($request->slug)?$request->slug:CommonMethod::buildSlug($request->name),
            'summary' => $request->summary,
            'content' => $request->content,
            'image' => CommonMethod::removeDomainUrl($request->image),
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'meta_image' => CommonMethod::removeDomainUrl($request->meta_image),
            'images' => $images,
            'type_main_id' => $request->type_main_id,
            'type' => $request->type,
            'seri' => $request->seri,
            'nation' => $request->nation,
            'kind' => $request->kind,
            'lang' => $request->lang,
            'status' => $request->status,
            'start_date' => ($request->start_date)?$request->start_date:$data->start_date,
        ]);

        // update post type relation
        if(!empty($request->posttype_id)) {
            $data->posttypes()->sync($request->posttype_id);
        } else {
            $data->posttypes()->detach();
        }
        // update post tag relation
        if(!empty($request->posttag_id)) {
            $data->posttags()->sync($request->posttag_id);
        } else {
            $data->posttags()->detach();
        }

        return back()->with('success', trans('titles.updateSuccess'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Post::findOrFail($id);

        if(!empty($data)) {
        	$data->posttypes()->detach();
	        $data->posttags()->detach();
	        $data->postchaps()->delete();
	        $data->delete();

            return redirect('posts')->with('success', trans('titles.deleteSuccess'));
        }

        return back()->with('error', trans('titles.deleteError'));
    }

    public function updateStatus(Request $request)
    {
        $id = $request->id;
        $field = $request->field;
        if($id && $field) {
            $data = Post::find($id);
            if(!empty($data)) {
                $status = ($data->$field == 1) ? 2 : 1;
                $data->update([$field=>$status]);
                return 1;
            }
        }
        return 0;
    }

    public function callUpdateStatus(Request $request)
    {
        $id = $request->id;
        $field = $request->field;
        if($id && $field) {
            foreach($id as $key => $value) {
                $data = Post::find($value);
                if(!empty($data)) {
                    $status = ($data->$field == 1) ? 2 : 1;
                    $data->update([$field=>$status]);
                }
            }
            return 1;
        }
        return 0;
    }

    public function callDelete(Request $request)
    {
        $id = $request->id;
        if($id) {
            foreach($id as $key => $value) {
                $data = Post::find($value);
                if(!empty($data)) {
                	$data->posttypes()->detach();
			        $data->posttags()->detach();
			        $data->postchaps()->delete();
			        $data->delete();
                }
            }
            return 1;
        }
        return 0;
    }

    public function callUpdateType(Request $request)
    {
        $id = $request->id;
        $posttype_id = $request->posttype_id;
        $type_main_id = $request->type_main_id;
        if($id && $type_main_id && $posttype_id) {
            foreach($id as $key => $value) {
                $data = Post::find($value);
                if(!empty($data)) {
                	//update post
	                $data->update([
	                    'type_main_id' => $type_main_id,
	                ]);
	                // update post type relation
	                $data->posttypes()->sync($posttype_id);
                }
            }
            return 1;
        }
        return 0;
    }

}
