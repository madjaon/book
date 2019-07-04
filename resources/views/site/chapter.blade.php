@php
  $extendData = array(
		'meta_title' => ($rs->meta_title)?$rs->meta_title:$rs->h1,
		'meta_keyword' => $rs->meta_keyword,
		'meta_description' => $rs->meta_description,
		'meta_image' => $rs->meta_image,
    'fullcol' => TRUE,
	);
@endphp

@extends('layouts.master', $extendData)

@section('title', $extendData['meta_title'])

@section('content')

@php
	$breadcrumb = array();
	foreach($post->types as $value) {
		$breadcrumb[] = ['name' => $value->name, 'link' => url('the-loai/' . $value->slug)];
	}
	$breadcrumb[] = ['name' => $post->name, 'link' => url($post->slug)];
	$breadcrumb[] = ['name' => $rs->h1, 'link' => ''];
@endphp

@include('site.common.breadcrumb', $breadcrumb)

<h1 class="my-3 text-center">{{ $rs->h1 }}</h1>

@if(!empty($rs->summary))<div class="des mb-3">{!! $rs->summary !!}</div>@endif

<div class="text-center mb-3 d-flex justify-content-center align-items-center">
  @if(isset($rs->epPrev))
    <a href="{{ url($post->slug . '/' . $rs->epPrev->slug) }}" class="btn btn-primary m-2" rel="prev"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
  @else
    <a class="btn btn-secondary m-2 disabled"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
  @endif

  {!! Form::select(null, $post->chapsArray, url($post->slug . '/' . $rs->slug), array('class' =>'custom-select m-2', 'style'=>'width:200px;', 'onchange'=>'javascript:location.href = this.value;')) !!}

  @if(isset($rs->epNext))
    <a href="{{ url($post->slug . '/' . $rs->epNext->slug) }}" class="btn btn-primary m-2" rel="next"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
  @else
    <a class="btn btn-secondary m-2 disabled"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
  @endif
</div>

@include('site.common.ad', ['posPc' => 15, 'posMobile' => 16])

@if(!empty($rs->content))<div class="mb-3">{!! $rs->content !!}</div>@endif

@include('site.common.ad', ['posPc' => 17, 'posMobile' => 18])

<div class="text-center mb-3 d-flex justify-content-center align-items-center">
  @if(isset($rs->epPrev))
    <a href="{{ url($post->slug . '/' . $rs->epPrev->slug) }}" class="btn btn-primary m-2" rel="prev"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
  @else
    <a class="btn btn-secondary m-2 disabled"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
  @endif

  {!! Form::select(null, $post->chapsArray, url($post->slug . '/' . $rs->slug), array('class' =>'custom-select m-2', 'style'=>'width:200px;', 'onchange'=>'javascript:location.href = this.value;')) !!}

  @if(isset($rs->epNext))
    <a href="{{ url($post->slug . '/' . $rs->epNext->slug) }}" class="btn btn-primary m-2" rel="next"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
  @else
    <a class="btn btn-secondary m-2 disabled"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
  @endif
</div>

<div class="mb-3 text-center">
  <a class="badge badge-danger" href="{{ url('contact') }}" title="Báo lỗi"><i class="fa fa-exclamation-triangle mr-1" aria-hidden="true"></i>Báo lỗi</a>
</div>

<div class="social mb-4">
  <div class="fb-like" data-share="true" data-show-faces="false" data-layout="button_count"></div>
</div>

<div class="comment mb-5">
  <div class="fb-comments" data-numposts="10" data-colorscheme="dark" data-width="100%" data-href="{{ url($post->slug) }}"></div>
</div>

@endsection