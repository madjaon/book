<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  @if(!empty($is404))
    <meta name="robots" content="noindex,nofollow,noodp" />
  @else
    <meta name="robots" content="noindex,nofollow,noodp" />
  @endif

  <meta name="language" content="vietnamese" />
  <meta name="title" content="{{ $meta_title }}">
  <meta name="keywords" content="{{ $meta_keyword }}">
  <meta name="description" content="{{ $meta_description }}">
  <meta property="og:site_name" content="{{ env('APP_NAME') }}" />
  <meta property="og:url" content="{{ url()->current() }}" />
  <meta property="og:title" content="{{ $meta_title }}" />
  <meta property="og:description" content="{{ $meta_description }}" />
  <meta property="og:type" content="website" />
  @if(!empty($meta_image))
    <meta property="og:image" content="{{ url($meta_image) }}" />
  @endif

  @if(!empty($config->fb_app_id))
    <meta property="fb:app_id" content="{{ $config->fb_app_id }}" />
  @endif

  <meta name="csrf-token" content="%%csrf_token%%">
  
  <title>@yield('title')</title>
  
  <link rel="alternate" hreflang="{{ config('app.locale') }}" href="{{ env('APP_URL') }}" />

  @if(!empty($pagePrev))
    <link rel="prev" href="{{ preg_replace('/(\?|&)page=1/', '', $pagePrev) }}">
  @endif

  @if(!empty($pageNext))
    <link rel="next" href="{{ $pageNext }}">
  @endif

  @if(!!empty($pagePrev) && !empty($pageNext))
    <link rel="canonical" href="{{ preg_replace('/(\?|&)page=2/', '', $pageNext) }}">
  @endif

  @if(!empty($config->headercode))
    {!! $config->headercode !!}
  @endif

  <link rel="apple-touch-icon" sizes="180x180" href="{{ url('images/logo/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ url('images/logo/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ url('images/logo/favicon-16x16.png') }}">
  <link rel="manifest" href="{{ url('images/logo/manifest.json') }}">
  <link rel="mask-icon" href="{{ url('images/logo/safari-pinned-tab.svg') }}" color="#433d82">
  <link rel="shortcut icon" href="{{ url('images/logo/favicon.ico') }}">
  <meta name="apple-mobile-web-app-title" content="{{ env('APP_NAME') }}">
  <meta name="application-name" content="{{ env('APP_NAME') }}">
  <meta name="msapplication-config" content="{{ url('images/logo/browserconfig.xml') }}">
  <meta name="theme-color" content="#ffffff">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/css/bootstrap.min.css" integrity="sha384-Zug+QiDoJOrZ5t4lssLdxGhVrurbmBWopoEl+M6BdEfwnCJZtKxi1KgxUyJq13dy" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ mix('/css/min.css') }}">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.3/js/bootstrap.min.js" integrity="sha384-a5N7Y/aK3qNeh15eJKGWxsqtnX/wWdSZSKp+81YjTmS15nvnvxKHuzaWwXHDli+4" crossorigin="anonymous"></script>
  <script src="{{ mix('/js/s.js') }}"></script>
  @stack('scroll')
  @stack('book')
  @stack('bookpaging')
  @stack('starability')
  @stack('recaptcha')
</head>

<body>

  @if(!empty($isPost) && !empty($config->fb_app_id))
  <script>
    window.fbAsyncInit = function() {
      FB.init({
        appId      : '{{ $config->fb_app_id }}',
        xfbml      : true,
        version    : 'v2.9'
      });
      FB.AppEvents.logPageView();
    };

    (function(d, s, id){
       var js, fjs = d.getElementsByTagName(s)[0];
       if (d.getElementById(id)) {return;}
       js = d.createElement(s); js.id = id;
       js.src = "//connect.facebook.net/en_US/sdk.js";
       fjs.parentNode.insertBefore(js, fjs);
     }(document, 'script', 'facebook-jssdk'));
  </script>
  @endif

  @include('site.common.top')

  <div class="container master">
    <div class="row">
      @if(isset($fullcol))
      <div class="col">
        <div class="content">
          @yield('content')
        </div>
      </div>
      @else
      <div class="col-md-9">
        <div class="content">
          @yield('content')
        </div>
      </div>
      <div class="col-md-3">
        @include('site.common.side')
      </div>
      @endif
    </div>
  </div>

  @include('site.common.bot')

  @if(getDevice() == DESKTOP)
    @if(CommonQuery::checkAdByPosition(5) || CommonQuery::checkAdByPosition(6))
      <div class="scrollSticky" id="scrollLeft" data-top="110">
        @include('site.common.ad', ['posPc' => 5])
      </div>
      <div class="scrollSticky" id="scrollRight" data-top="110">
        @include('site.common.ad', ['posPc' => 6])
      </div>
      @push('scroll')
        <script src="{{ mix('/js/scroll.js') }}"></script>
        <!-- <style>@media(min-width:1200px){.container{width:1000px;}}</style> -->
      @endpush
    @endif
  @endif

  @if(!empty($config->footercode))
    {!! $config->footercode !!}
  @endif

</body>
</html>
