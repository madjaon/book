<?php

namespace App\Http\Controllers;

use App\Models\PostTag;
use App\Helpers\CommonMethod;
use Auth;
use Illuminate\Http\Request;
use Validator;
use DB;

class PostTagsController extends Controller
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
            $data = PostTag::paginate(PAGINATION);
        }

        return view('posttags.index', ['data' => $data, 'request' => $request]);
    }

    private function searchData($request)
    {
        $data = DB::table('posttags')->where(function ($query) use ($request) {
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
        })
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
        return view('posttags.create');
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
	            'slug' 				=> 'required|max:191|unique:posttags',
	            'summary' 			=> 'max:500',
	            'image' 			=> 'max:191',
	            'meta_title' 		=> 'max:191',
	            'meta_keyword' 		=> 'max:191',
	            'meta_description' 	=> 'max:300',
	            'meta_image' 		=> 'max:191',
            ],
            self::validationMsg()
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $post = PostTag::create([
            'name' => $request->name,
            'slug' => ($request->slug)?$request->slug:CommonMethod::buildSlug($request->name),
            'summary' => $request->summary,
            'content' => $request->content,
            'image' => CommonMethod::removeDomainUrl($request->image),
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'meta_image' => CommonMethod::removeDomainUrl($request->meta_image),
            'lang' => $request->lang,
            'status' => $request->status,
            'start_date' => ($request->start_date)?$request->start_date:date('Y-m-d H:i:s'),
        ]);

        return redirect('posttags')->with('success', trans('titles.createSuccess'));
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
        // $data = PostTag::find($id);

        // return view('posttags.show')->withUser($user);
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
        $data = PostTag::findOrFail($id);

        return view('posttags.edit')->with(['data' => $data]);
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
        $data = PostTag::find($id);

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
            $rules['slug'] = 'required|max:191|unique:posttags';
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
        $data = PostTag::findOrFail($id);

        if(!empty($data)) {
	        $data->delete();

            return redirect('posttags')->with('success', trans('titles.deleteSuccess'));
        }

        return back()->with('error', trans('titles.deleteError'));
    }

    public function updateStatus(Request $request)
    {
        $id = $request->id;
        $field = $request->field;
        if($id && $field) {
            $data = PostTag::find($id);
            if(!empty($data)) {
                $status = ($data->$field == 1) ? 2 : 1;
                $data->update([$field=>$status]);
                return 1;
            }
        }
        return 0;
    }

}
