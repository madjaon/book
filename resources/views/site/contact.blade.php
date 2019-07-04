@php
  $extendData = array(
      'meta_title' => 'Contact',
      'meta_keyword' => 'Contact',
      'meta_description' => 'Contact',
      'meta_image' => DEFAULT_AVATAR,
      'fullcol' => TRUE,
    );
@endphp

@extends('layouts.master', $extendData)

@section('title', 'Contact')

@section('content')

<h1 class="d-inline-flex py-2 mb-0 mt-3">Contact Us</h1>

<hr>

@include('partials.form-status')

<div class="row">
    <div class="col-sm-7">
        <form class="mb-3" method="POST" action="{{ url('contact') }}">
            <input type="hidden" name="_token" value="%%csrf_token%%">
            <div class="form-group">
                <label for="name">Họ Tên / Fullname <span style="color: red;">(*)</span></label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email address <span style="color: red;">(*)</span></label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email" value="{{ old('email') }}" required>
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="msg">Tin Nhắn / Message <span style="color: red;">(*)</span></label>
                <textarea class="form-control" id="msg" name="msg" rows="6" maxlength="1000" required>{{ old('msg') }}</textarea>
            </div>
            @if(config('settings.reCaptchStatus'))
                <div class="form-group">
                    <div class="g-recaptcha" data-sitekey="{{ env('RE_CAP_SITE') }}"></div>
                </div>
                @push('recaptcha')
                    <script src='https://www.google.com/recaptcha/api.js'></script>
                @endpush
            @endif
            <button type="submit" class="btn btn-primary">Send Message</button>
        </form>
    </div>
    <div class="col-sm-5">
        <h3 class="mb-3">Bạn muốn liên hệ với chúng tôi.</h3>
        <p>Vui lòng gửi email theo địa chỉ:</p>
        <p><a href="mailto:contact@truyendem.com" rel="nofollow" title="Send Email">contact@truyendem.com</a></p>
    </div>
</div>

@endsection