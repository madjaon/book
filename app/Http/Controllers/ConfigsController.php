<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Helpers\CommonMethod;
use Auth;
use Illuminate\Http\Request;
use Validator;

class ConfigsController extends Controller
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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id = 1)
    {
        $data = Config::findOrFail($id);

        return view('configs.edit')->with(['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = 1)
    {
        $data = Config::find($id);

        $validator = Validator::make($request->all(),
            [
                'meta_title'        => 'max:191',
                'meta_keyword'      => 'max:191',
                'meta_description'  => 'max:300',
                'meta_image'        => 'max:191',
            ],
            self::validationMsg()
        );

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $data->update([
            'headercode' => $request->headercode,
            'footercode' => $request->footercode,
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'meta_image' => CommonMethod::removeDomainUrl($request->meta_image),
            'fb_app_id' => $request->fb_app_id,
            'lang' => $request->lang,
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
        //
    }

}
