@php
  $extendData = array(
      'meta_title' => ($config->meta_title)?$config->meta_title:trans('caption.homepage'),
      'meta_keyword' => $config->meta_keyword,
      'meta_description' => $config->meta_description,
      'meta_image' => $config->meta_image,
    );
@endphp

@extends('layouts.master', $extendData)

@section('title', env('APP_NAME'))

@section('content')

<h1 class="d-inline-flex py-2 mb-0 mt-3">{{ $extendData['meta_title'] }}</h1>

<hr>

@include('site.common.list', array('data' => $data))

@endsection