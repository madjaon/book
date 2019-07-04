@php
  $extendData = array(
		'meta_title' => ($rs->meta_title)?$rs->meta_title:$rs->h1,
		'meta_keyword' => $rs->meta_keyword,
		'meta_description' => $rs->meta_description,
		'meta_image' => $rs->meta_image,
		'pagePrev' => (count($data) > 0 && $data->lastPage() > 1)?$data->previousPageUrl():null,
    	'pageNext' => (count($data) > 0 && $data->lastPage() > 1)?$data->nextPageUrl():null
	);
@endphp

@extends('layouts.master', $extendData)

@section('title', $extendData['meta_title'])

@section('content')

@php
  $breadcrumb = array(
    ['name' => $rs->h1, 'link' => '']
  );
@endphp

@include('site.common.breadcrumb', $breadcrumb)

<h1 class="d-inline-flex py-2 mb-0">{{ $rs->h1 }}</h1>

@if(!empty($rs->content))<div class="des mb-3">{!! $rs->content !!}</div>@endif

<hr>

@if(isset($rs->type))
	@if($rs->type == 2)
		@include('site.common.list2', array('data' => $data))
	@else($rs->type == 3)
		@include('site.common.grid', array('data' => $data))
	@endif
@else
	@include('site.common.list', array('data' => $data))
@endif

@if(count($data) > 0 && $data->lastPage() > 1)
  @include('site.common.paginate', ['paginator' => $data])
@endif

@endsection