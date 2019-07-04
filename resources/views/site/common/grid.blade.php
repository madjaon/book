@if(count($data) > 0)
<div class="row mt-3">
  @foreach($data as $key => $value)
    @php
      $url = url($value->slug);
      $image = ($value->image)?CommonMethod::getThumbnail($value->image, 2):DEFAULT_AVATAR;
    @endphp
    <div class="col-6 col-sm-4">
      <figure class="figure text-center grid-item">
        <a href="{{ $url }}" title="{{ $value->name }}" class="d-block">
          <img src="{{ url($image) }}" class="figure-img img-thumbnail img-fluid rounded" alt="{{ $value->name }}">
          <span class="badge badge-warning">{{ CommonMethod::numberFormatDot($value->view) }} {{ trans('caption.views') }}</span>
        </a>
        <figcaption class="figure-caption">
          <a href="{{ $url }}" title="{{ $value->name }}">{{ $value->name }}</a>
        </figcaption>
      </figure>
    </div>
  @endforeach
</div>
@else
<div class="alert alert-warning" role="alert">
  <strong>{{ trans('caption.warning') }}</strong> {{ trans('caption.updating') }}
</div>
@endif