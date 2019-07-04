<?php

namespace App\Http\Controllers;

use App\Models\PostChap;
use App\Helpers\CommonMethod;
use Auth;
use Illuminate\Http\Request;
use Validator;
use DB;

class PostChapsController extends Controller
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
        if(count($request->request) == 0 || empty($request->post_id)) {
            return redirect('posts')->with('warning', trans('titles.wrongPath'));
        }

        if(!empty($request->issearch)) {
            $data = self::searchData($request);
        } else {
            $data = PostChap::where('post_id', $request->post_id)
                        ->orderByRaw(DB::raw("position = '0', position desc"))
                        ->orderBy('start_date', 'desc')
                        ->paginate(PAGINATION);
        }

        return view('postchaps.index', ['data' => $data, 'request' => $request]);
    }

    private function searchData($request)
    {
        $data = DB::table('postchaps')->where(function ($query) use ($request) {
            // condition
            if(!empty($request->keyword)) {
                $slug = CommonMethod::buildSlug($request->keyword);
                $query = $query->where('slug', 'like', '%'.$slug.'%');
                $query = $query->orWhere('name', 'like', '%'.$request->keyword.'%');
                $query = $query->orWhere('summary', 'like', '%'.$request->keyword.'%');
                $query = $query->orWhere('id', $request->keyword);
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
        // search only this post
        ->where('post_id', $request->post_id)
        ->orderByRaw(DB::raw("position = '0', position desc"))
        ->orderBy('start_date', 'desc')
        ->paginate(PAGINATION);
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('postchaps.create', ['request' => $request]);
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
	            'slug' 				=> 'required|max:191|unique:postchaps',
	            'summary' 			=> 'max:500',
	            'image' 			=> 'max:191',
	            'meta_title' 		=> 'max:191',
	            'meta_keyword' 		=> 'max:191',
	            'meta_description' 	=> 'max:300',
	            'meta_image' 		=> 'max:191',
	            'post_id' 		    => 'required',
            ],
            self::validationMsg()
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $post = PostChap::create([
            'name' => $request->name,
            'slug' => ($request->slug)?$request->slug:CommonMethod::buildSlug($request->name),
            'summary' => $request->summary,
            'content' => $request->content,
            'image' => CommonMethod::removeDomainUrl($request->image),
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'meta_image' => CommonMethod::removeDomainUrl($request->meta_image),
            'post_id' => $request->post_id,
            'volume' => $request->volume,
            'chapter' => $request->chapter,
            'lang' => $request->lang,
            'status' => $request->status,
            'start_date' => ($request->start_date)?$request->start_date:date('Y-m-d H:i:s'),
        ]);

        return redirect('postchaps/?post_id='.$request->post_id)->with('success', trans('titles.createSuccess'));
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
        // $data = PostChap::find($id);

        // return view('postchaps.show')->withUser($user);
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
        $data = PostChap::findOrFail($id);

        return view('postchaps.edit')->with(['data' => $data]);
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
        $data = PostChap::find($id);

        $rules = [
            'name' 				=> 'bail|required|max:191',
            'summary' 			=> 'max:500',
            'image' 			=> 'max:191',
            'meta_title' 		=> 'max:191',
            'meta_keyword' 		=> 'max:191',
            'meta_description' 	=> 'max:300',
            'meta_image' 		=> 'max:191',
        ];

        if($request->slug != $data->slug) {
            $rules['slug'] = 'required|max:191|unique:postchaps';
        }

        $validator = Validator::make($request->all(), $rules, self::validationMsg());

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
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
            'post_id' => $data->post_id,
            'volume' => $request->volume,
            'chapter' => $request->chapter,
            'lang' => $request->lang,
            'status' => $request->status,
            'start_date' => ($request->start_date)?$request->start_date:$data->start_date,
        ]);

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
        $data = PostChap::findOrFail($id);

        if(!empty($data)) {
            $postId = $data->post_id;
            
	        $data->delete();

            return redirect('postchaps/?post_id='.$postId)->with('success', trans('titles.deleteSuccess'));
        }

        return back()->with('error', trans('titles.deleteError'));
    }

    public function updateStatus(Request $request)
    {
        $id = $request->id;
        $field = $request->field;
        if($id && $field) {
            $data = PostChap::find($id);
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
                $data = PostChap::find($value);
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
            $data = PostChap::whereIn('id', $id)->delete();
            return 1;
        }
        return 0;
    }

    public function callUpdatePosition(Request $request)
    {
        $id = $request->id;
        $position = $request->position;
        if($id && $position) {
            foreach($id as $key => $value) {
                $data = PostChap::find($value);
                if(!empty($data)) {
                    $data->update(['position' => $position[$key]]);
                }
            }
            return 1;
        }
        return 0;
    }

}
