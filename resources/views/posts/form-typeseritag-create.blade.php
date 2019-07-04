@php 
	$posttypes = CommonQuery::getAllIdName('posttypes');
	$postseries = CommonQuery::getArrayWithStatus('postseries');
	$posttags = CommonQuery::getArrayWithStatus('posttags');
@endphp
@if($postseries || $posttags)
	@include('scripts.script-select2')
@endif
<div class="form-group has-feedback row {{ $errors->has('type_main_id') ? ' has-error ' : '' }}">
  {!! Form::label('type_main_id', trans('forms.form_label_category'), array('class' => 'col-md-3 control-label')); !!}
  <div class="col-md-9">
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
    @if ($errors->has('type_main_id'))
      <span class="help-block">
          <strong>{{ $errors->first('type_main_id') }}</strong>
      </span>
    @endif
  </div>
</div>

<div class="form-group has-feedback row {{ $errors->has('seri') ? ' has-error ' : '' }}">
	{!! Form::label('seri', trans('forms.form_label_seri'), array('class' => 'col-md-3 control-label')); !!}
	<div class="col-md-9">
	  <div class="input-group">
	    @if($postseries)
			{!! Form::select('seri', $postseries, old('seri'), array('class' => 'form-control select2limit', 'multiple' => 'multiple', 'data-placeholder' => trans('forms.form_ph_seri'), 'style' => 'width: 100%;')) !!}
		@else
			<i>Chưa có dữ liệu</i>
		@endif
	    <label class="input-group-addon" for="seri"><i class="fa fa-fw {{ trans('forms.form_icon_seri') }}" aria-hidden="true"></i></label>
	  </div>
	  @if ($errors->has('seri'))
	    <span class="help-block">
	        <strong>{{ $errors->first('seri') }}</strong>
	    </span>
	  @endif
	</div>
</div>

<div class="form-group has-feedback row {{ $errors->has('posttag_id') ? ' has-error ' : '' }}">
	{!! Form::label('posttag_id', trans('forms.form_label_tag'), array('class' => 'col-md-3 control-label')); !!}
	<div class="col-md-9">
	  <div class="input-group">
	    @if($posttags)
			{!! Form::select('posttag_id[]', $posttags, old('posttag_id'), array('class' => 'form-control select2', 'multiple' => 'multiple', 'data-placeholder' => trans('forms.form_ph_tag'), 'style' => 'width: 100%;')) !!}
		@else
			<i>Chưa có dữ liệu</i>
		@endif
	    <label class="input-group-addon" for="posttag_id"><i class="fa fa-fw {{ trans('forms.form_icon_tag') }}" aria-hidden="true"></i></label>
	  </div>
	  @if ($errors->has('posttag_id'))
	    <span class="help-block">
	        <strong>{{ $errors->first('posttag_id') }}</strong>
	    </span>
	  @endif
	</div>
</div>
