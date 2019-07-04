<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Helpers\CommonMethod;
use Auth;
use Illuminate\Http\Request;
use Validator;
use DB;

class AdsController extends Controller
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
                'position.required' => trans('validation.positionRequired'),
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
            $data = Ad::orderBy('start_date', 'desc')->paginate(PAGINATION);
        }

        return view('ads.index', ['data' => $data, 'request' => $request]);
    }

    private function searchData($request)
    {
        $data = DB::table('ads')->where(function ($query) use ($request) {
            // condition
            if(!empty($request->keyword)) {
                $slug = CommonMethod::buildSlug($request->keyword);
                $query = $query->where('name', 'like', '%'.$slug.'%');
                $query = $query->orWhere('url', 'like', '%'.$request->keyword.'%');
                $query = $query->orWhere('id', $request->keyword);
            }
            if(!empty($request->position)) {
                $query = $query->where('position', $request->position);
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
        return view('ads.create');
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
                'name'              => 'max:191',
            	'position'          => 'required',
	            'image' 			=> 'max:191',
	            'url' 		        => 'max:500',
            ],
            self::validationMsg()
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $post = Ad::create([
            'name' => $request->name,
            'code' => $request->code,
            'position' => $request->position,
            'code' => $request->code,
            'image' => CommonMethod::removeDomainUrl($request->image),
            'url' => $request->url,
            'lang' => $request->lang,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect('ads')->with('success', trans('titles.createSuccess'));
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
        // $data = Ad::find($id);

        // return view('ads.show')->withUser($user);
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
        $data = Ad::findOrFail($id);

        return view('ads.edit')->with(['data' => $data]);
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
        $data = Ad::find($id);

        $validator = Validator::make($request->all(),
            [
                'name'              => 'max:191',
                'position'          => 'required',
                'image'             => 'max:191',
                'url'               => 'max:500',
            ],
            self::validationMsg()
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data->update([
            'name' => $request->name,
            'code' => $request->code,
            'position' => $request->position,
            'code' => $request->code,
            'image' => CommonMethod::removeDomainUrl($request->image),
            'url' => $request->url,
            'lang' => $request->lang,
            'status' => $request->status,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
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
        $data = Ad::findOrFail($id);

        if(!empty($data)) {
	        $data->delete();

            return redirect('ads')->with('success', trans('titles.deleteSuccess'));
        }

        return back()->with('error', trans('titles.deleteError'));
    }

    public function updateStatus(Request $request)
    {
        $id = $request->id;
        $field = $request->field;
        if($id && $field) {
            $data = Ad::find($id);
            if(!empty($data)) {
                $status = ($data->$field == 1) ? 2 : 1;
                $data->update([$field=>$status]);
                return 1;
            }
        }
        return 0;
    }

}
