<div class="menubox animated zoomInDownNew">
  <div class="list-group">
    <a href="#" class="list-group-item list-group-item-action list-group-item-success" title="Close" onclick="document.getElementById('menumobile').style.display='none'"><i class="fa fa-window-close mr-2" aria-hidden="true"></i>Close Menu</a>
    <a href="{{ url('/') }}" class="list-group-item list-group-item-action" title="{{ trans('caption.homepage') }}"><i class="fa fa-home mr-2" aria-hidden="true"></i>{{ trans('caption.homepage') }}</a>
    <a href="{{ url('truyen-tranh') }}" class="nav-link" class="list-group-item list-group-item-action">Truyện Tranh</a>
  	<a href="{{ url('anh-dep') }}" class="nav-link" class="list-group-item list-group-item-action">Ảnh Đẹp</a>
    @foreach($data as $value)
      <a href="{{ url('the-loai/' . $value->slug) }}" class="list-group-item list-group-item-action" title="Thể loại {{ $value->name }}">{{ $value->name }}</a>
    @endforeach
    <a href="#" class="list-group-item list-group-item-action list-group-item-success" title="Close" onclick="document.getElementById('menumobile').style.display='none'"><i class="fa fa-window-close mr-2" aria-hidden="true"></i>Close Menu</a>
  </div>
</div>
