@if(count($data) > 0)
<div class="row mt-4">
  @foreach($data as $key => $value)
    @php
      $url = url($value->slug);
      $kind = CommonOption::getKind($value->kind);
      if($value->kind == 2) {
        $badge = 'primary';
      } else {
        $badge = 'success';
      }
    @endphp
    <div class="col-12">
      <div class="media mb-3 pb-3">
        <div class="media-body">
          <h2 class="mt-0 mb-2"><a href="{{ $url }}" title="{{ $value->name }}">{{ $value->name }}</a></h2>
          <div class="d-flex align-items-center">
            <span class="badge badge-{{ $badge }}">{{ $kind }}</span>
            <small class="ml-2 text-muted">{{ CommonMethod::numberFormatDot($value->view) }} {{ trans('caption.views') }}</small>
          </div>
          @if(!empty($value->summary))<div class="d-block my-3">{!! $value->summary !!}</div>@endif
        </div>
      </div>
    </div>
  @endforeach
</div>
@else
<div class="alert alert-warning" role="alert">
  <strong>{{ trans('caption.warning') }}</strong> {{ trans('caption.updating') }}
</div>
@endif