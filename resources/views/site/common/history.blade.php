@if(isset($reading))
<div class="side my-5 animated fadeInDownNew">
  <div class="card">
    <div class="card-body p-3">
      <h4 class="card-title">Bạn đã đọc<i class="fa fa-question-circle-o ml-2" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="Được lưu vào lịch sử trình duyệt web"></i></h4>
      <p class="card-text">
        <a href="{{ $reading->url }}" title="{{ $reading->postName }}" class="mr-2">{{ $reading->postName }}<br> @if(isset($reading->chapterCaption)) <span class="badge badge-secondary d-inline-block">{{ $reading->chapterCaption }}</span> @endif </a>
      </p>
    </div>
  </div>
</div>
@endif