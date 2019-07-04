@php 
	$posttypes = CommonQuery::getAllIdName('posttypes');
@endphp
<div class="form-group has-feedback">
  	<div class="table-responsive list-border">
	    <div class="list-box">
    		<div class="input-group">
				@if($posttypes)
					<input type="hidden" name="type_main_id" value="0" required>
					<ul class="todo-list">
						@foreach($posttypes as $key => $value)
							<li class="post-type-list">
								<input type="checkbox" name="posttype_id[]" value="{{ $value->id }}" class="posttype_id" id="posttype_id_{{ $value->id }}" onclick="checkPostType({{ $value->id }});" />
								<label for="posttype_id_{{ $value->id }}">{{ $value->name }}</label>
								<small class="label label-success primary" id="primary_{{ $value->id }}" style="display: none;"><i class="fa fa-key"></i> Primary</small>
								<small class="make_primary" id="make_primary_{{ $value->id }}" onclick="checkKey({{ $value->id }}, 'primary', 'type_main_id');" style="cursor: pointer; display: none;"> Primary</small>
							</li>
						@endforeach
					</ul>
					@include('scripts.script-check-posttype')
				@else
					<i>Chưa có dữ liệu</i>
				@endif
		    </div>
	    </div>
    </div>
</div>
