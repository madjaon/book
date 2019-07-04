@php
  $extendData = array(
		'meta_title' => ($rs->meta_title)?$rs->meta_title:$rs->h1,
		'meta_keyword' => $rs->meta_keyword,
		'meta_description' => $rs->meta_description,
		'meta_image' => $rs->meta_image,
	);

	$image = ($rs->image)?CommonMethod::getThumbnail($rs->image, 1):DEFAULT_AVATAR;
	$ratingCookieName = 'rating' . $rs->id;
	$ratingCookie = isset($_COOKIE[$ratingCookieName])?$_COOKIE[$ratingCookieName]:null;
	$ratingValue = round($rs->rating_value, 1, PHP_ROUND_HALF_UP);
	$ratingValueChecked = round($ratingValue, 0, PHP_ROUND_HALF_DOWN);
@endphp

@extends('layouts.master', $extendData)

@section('title', $extendData['meta_title'])

@section('content')

@php
  $breadcrumb = array();
  foreach($rs->types as $value) {
    $breadcrumb[] = ['name' => $value->name, 'link' => url('the-loai/' . $value->slug)];
  }
  $breadcrumb[] = ['name' => $rs->h1, 'link' => ''];
@endphp

@include('site.common.breadcrumb', $breadcrumb)

<div itemscope itemtype="http://schema.org/Book">

<div class="row book">
  <div class="col">
	
  	<meta itemprop="image" content="{{ url($image) }}">
    
    <input type="hidden" id="id" value="{{ $rs->id }}">

    <h1 class="mb-3" itemprop="name">{{ $rs->h1 }}</h1>

    @php 
      if($rs->kind == 2) {
        $badge = 'primary';
      } else {
        $badge = 'success';
      }
    @endphp 
    <div class="book-info mb-3 d-flex align-items-center">
      <span class="badge badge-{{ $badge }}">{{ $rs->kindName }}</span>
      <span class="mx-1"> / Lượt đọc: {{ CommonMethod::numberFormatDot($rs->view) }}</span>
      <span class="mx-1"> / Quốc Gia: {{ $rs->nationName }}</span>
    </div>
   
	 @if(count($rs->types) > 0)
    <div class="book-info">Thể Loại: 
      @foreach($rs->types as $key => $value)
        @php echo ($key > 0)?' - ':''; @endphp <a href="{{ url('the-loai/' . $value->slug) }}" title="Thể loại truyện {{ $value->name }}" itemprop="genre">{{ $value->name }}</a>
      @endforeach
    </div>
    @endif

    @if(isset($rs->epFirst) || isset($rs->epLast))
      @if($rs->epFirst->id == $rs->epLast->id)
        <div class="row mt-3">
          <div class="col-md-6">
            <a class="btn btn-danger mb-3 w-100 book-full" href="{{ url($rs->slug . '/' . $rs->epFirst->slug) }}">Đọc Ngay</a>
          </div>
        </div>
      @else
        <div class="row mt-3">
          <div class="col-md-6">
            <a class="btn btn-info mb-3 w-100 book-first" href="{{ url($rs->slug . '/' . $rs->epFirst->slug) }}">Đọc Chương Đầu</a>
          </div>
          <div class="col-md-6">
            <a class="btn btn-danger mb-3 w-100 book-last" href="{{ url($rs->slug . '/' . $rs->epLast->slug) }}">Chương Mới Nhất</a>
          </div>
        </div>
      @endif
    @endif

  </div>
</div>

<div class="row">
  <div class="col">

    @include('site.common.ad', ['posPc' => 11, 'posMobile' => 12])

    @if(count($rs->eps) > 0)
      <div class="mb-3 mt-2 d-flex justify-content-center align-items-center">
        <div id="chapters">
          @include('site.common.chapters')
        </div>
      </div>
      <!-- <div class="text-center"><div class="spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div></div> -->
      @if($rs->totalPageEps > 1)
        @push('bookpaging')
          <script src="{{ mix('/js/bp.js') }}"></script>
        @endpush
      @endif
    @endif
	
	<hr>

	@if(!empty($rs->content))<div class="des mb-3">{!! $rs->content !!}</div>@endif

	<hr>

	<div class="d-block d-sm-flex justify-content-center align-items-center text-center">
      <div class="d-flex justify-content-center align-items-center mr-3 mb-0" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
        <em><span id="ratingValue" itemprop="ratingValue">{{ $ratingValue }}</span> điểm / <span id="ratingCount" itemprop="ratingCount">{{ $rs->rating_count }}</span> lượt đánh giá</em>
        <meta itemprop="bestRating" content="10">
        <meta itemprop="worstRating" content="1">
      </div>
      <form class="d-flex justify-content-center align-items-center" name="ratingfrm">
        <fieldset class="starability-growRotate">
          <input type="radio" id="growing-rate1" name="rating" value="1" @if(isset($ratingCookie)) disabled @endif @if($ratingValueChecked == 1) checked @endif>
          <label for="growing-rate1" title="Quá tệ hại">1 star</label>
          <input type="radio" id="growing-rate2" name="rating" value="2" @if(isset($ratingCookie)) disabled @endif @if($ratingValueChecked == 2) checked @endif>
          <label for="growing-rate2" title="Tốn thời gian">2 stars</label>
          <input type="radio" id="growing-rate3" name="rating" value="3" @if(isset($ratingCookie)) disabled @endif @if($ratingValueChecked == 3) checked @endif>
          <label for="growing-rate3" title="Không thể hiểu">3 stars</label>
          <input type="radio" id="growing-rate4" name="rating" value="4" @if(isset($ratingCookie)) disabled @endif @if($ratingValueChecked == 4) checked @endif>
          <label for="growing-rate4" title="Thiếu gia vị">4 stars</label>
          <input type="radio" id="growing-rate5" name="rating" value="5" @if(isset($ratingCookie)) disabled @endif @if($ratingValueChecked == 5) checked @endif>
          <label for="growing-rate5" title="Cũng tàm tạm">5 stars</label>
          <input type="radio" id="growing-rate6" name="rating" value="6" @if(isset($ratingCookie)) disabled @endif @if($ratingValueChecked == 6) checked @endif>
          <label for="growing-rate6" title="Cũng được">6 stars</label>
          <input type="radio" id="growing-rate7" name="rating" value="7" @if(isset($ratingCookie)) disabled @endif @if($ratingValueChecked == 7) checked @endif>
          <label for="growing-rate7" title="Khá hay">7 stars</label>
          <input type="radio" id="growing-rate8" name="rating" value="8" @if(isset($ratingCookie)) disabled @endif @if($ratingValueChecked == 8) checked @endif>
          <label for="growing-rate8" title="Cực hay">8 stars</label>
          <input type="radio" id="growing-rate9" name="rating" value="9" @if(isset($ratingCookie)) disabled @endif @if($ratingValueChecked == 9) checked @endif>
          <label for="growing-rate9" title="Siêu phẩm">9 stars</label>
          <input type="radio" id="growing-rate10" name="rating" value="10" @if(isset($ratingCookie)) disabled @endif @if($ratingValueChecked == 10) checked @endif>
          <label for="growing-rate10" title="Kiệt tác">10 stars</label>
        </fieldset>
        @push('starability')
          <link rel="stylesheet" href="{{ mix('/css/starability.css') }}">
        @endpush
        @if(!isset($ratingCookie))
          @push('book')
            <script src="{{ mix('/js/b.js') }}"></script>
          @endpush
        @endif
      </form>
    </div>

    @if(!empty($rs->seriInfo))
    <hr>
      <div class="book-seri mb-3">Chủ đề: <a href="{{ url('chu-de/' . $rs->seriInfo->slug) }}" title="Chủ đề truyện {{ $rs->seriInfo->name }}">{{ $rs->seriInfo->name }}</a></div>
      @if(count($rs->seriData) > 0)
      <blockquote class="blockquote">
        <ul class="list-unstyled">
          @foreach($rs->seriData as $value)
          @php 
            $url = url($value->slug);
            $kind = CommonOption::getKind($value->kind);
            if($value->kind == 2) {
              $badge = 'primary';
            } else {
              $badge = 'success';
            }
          @endphp 
            <li>
              <a href="{{ $url }}" title="{{ $value->name }}"><i class="fa fa-angle-right mr-2" aria-hidden="true"></i>{{ $value->name }}<span class="badge badge-{{ $badge }} ml-2 align-middle hidden-xs-down">{{ $kind }}</span></a>
            </li>
          @endforeach
        </ul>
      </blockquote>
      @endif
    @endif

  	@if(count($rs->tags) > 0)
  	<hr>
    <div class="book-tag mb-3">Tags: 
        @foreach($rs->tags as $key => $value)
          <a href="{{ url('tag/' . $value->slug) }}" title="{{ $value->name }}" class="d-inline-block m-1 p-1">{{ $value->name }}</a>
        @endforeach
    </div>
    @endif

    @include('site.common.ad', ['posPc' => 13, 'posMobile' => 14])

    <div class="social mb-4">
		<div class="fb-like" data-share="true" data-show-faces="false" data-layout="button_count"></div>
	</div>
    
    <div class="comment mb-5">
      <div class="fb-comments" data-numposts="10" data-colorscheme="light" data-width="100%" data-href="{{ url($rs->slug) }}"></div>
    </div>

  </div>
</div>

</div>

@endsection