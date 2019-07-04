@if(getDevice() == MOBILE)
<header class="mb-4">
  <div class="container">
    <div class="row">
      <div class="col-8">
        <a href="{{ url('/') }}" class="d-flex justify-content-start align-items-center py-2 logo" title="{{ env('APP_NAME') }}">{{ env('APP_NAME') }}</a>  
      </div>
      <div class="col-4">
        <a class="d-flex justify-content-end py-2 text-primary" onclick="document.getElementById('menumobile').style.display='block'"><i class="fa fa-align-justify menuicon" aria-hidden="true"></i></a>
      </div>
    </div>
    <div class="row">
      <div class="col">
        <form action="{{ url('search') }}" method="GET" class="form-inline my-3 search">
          <div class="input-group">
            <input name="s" type="text" value="" class="form-control" placeholder="Tìm kiếm" id="search" maxlength="255">
            <div class="input-group-append">
              <button class="btn btn-secondary" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</header>
<div class="menumobile" id="menumobile">
  {!! $menumobile !!}
</div>
@else
<header class="mb-4">
  <nav class="navbar navbar-expand-sm py-1">
    <div class="container">
      <a class="navbar-brand p-0 d-flex align-items-center" href="{{ url('/') }}" title="{{ env('APP_NAME') }}">{{ env('APP_NAME') }}</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="hover" aria-haspopup="true" aria-expanded="false">Thể loại</a>
              {!! $menutypes !!}
          </li>
          <li class="nav-item"><a href="{{ url('truyen-tranh') }}" class="nav-link">Truyện Tranh</a></li>
          <li class="nav-item"><a href="{{ url('anh-dep') }}" class="nav-link">Ảnh Đẹp</a></li>
        </ul>
        <form action="{{ url('search') }}" method="GET" class="form-inline my-2 my-lg-0 search">
          <div class="input-group">
            <input name="s" type="text" value="" class="form-control" placeholder="Tìm kiếm" id="search" maxlength="255">
            <div class="input-group-append">
              <button class="btn btn-secondary" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </nav>
</header>
@endif
