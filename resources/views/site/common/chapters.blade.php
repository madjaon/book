<div class="d-flex justify-content-center align-items-center">
  @if($rs->totalPageEps > 1)
    @if($rs->currentPageEps > 1)
      <button class="btn btn-dark m-1" onclick="paging(1)"><i class="fa fa-angle-double-left" aria-hidden="true"></i></button>
    @else
      <button class="btn btn-dark m-1 disabled"><i class="fa fa-angle-double-left" aria-hidden="true"></i></button>
    @endif
    @if(isset($rs->prevPageEps))
      <button class="btn btn-dark m-1" onclick="paging({{ $rs->prevPageEps }})"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
    @else
      <button class="btn btn-dark m-1 disabled"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
    @endif
  @endif

  <ul class="list-unstyled m-0 p-0 animated fadeInNew">
    @foreach($rs->eps as $value)
    <?php 
      if($value->volume > 0) {
        $name = $value->volume . ' - ' . $value->chapter;
      } else {
        $name = $value->chapter;
      }
    ?>
      <li class="d-inline-block">
        <a href="{{ url($rs->slug . '/' . $value->slug) }}" title="{{ $value->name }}" class="btn btn-secondary m-1">{{ $name }}</a>
      </li>
    @endforeach
  </ul>

  @if($rs->totalPageEps > 1)
    @if(isset($rs->nextPageEps))
      <button class="btn btn-dark m-1" onclick="paging({{ $rs->nextPageEps }})"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
    @else
      <button class="btn btn-dark m-1 disabled"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
    @endif
    @if($rs->currentPageEps < $rs->totalPageEps)
      <button class="btn btn-dark m-1" onclick="paging({{ $rs->totalPageEps }})"><i class="fa fa-angle-double-right" aria-hidden="true"></i></button>
    @else
      <button class="btn btn-dark m-1 disabled"><i class="fa fa-angle-double-right" aria-hidden="true"></i></button>
    @endif
  @endif
  
</div>