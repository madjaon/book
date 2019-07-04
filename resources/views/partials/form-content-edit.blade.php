<div class="form-group has-feedback row {{ $errors->has('name') ? ' has-error ' : '' }}">
  {!! Form::label('name', trans('forms.form_label_name'), array('class' => 'col-md-3 control-label')); !!}
  <div class="col-md-9">
    <div class="input-group">
      {!! Form::text('name', old('name'), array('id' => 'name', 'class' => 'form-control', 'placeholder' => trans('forms.form_ph_name'), 'onkeyup' => 'convertToSlug(this.value)')) !!}
      <label class="input-group-addon" for="name"><i class="fa fa-fw {{ trans('forms.form_icon_name') }}" aria-hidden="true"></i></label>
    </div>
    @if ($errors->has('name'))
      <span class="help-block">
          <strong>{{ $errors->first('name') }}</strong>
      </span>
    @endif
  </div>
</div>

<div class="form-group has-feedback row {{ $errors->has('slug') ? ' has-error ' : '' }}">
  {!! Form::label('slug', trans('forms.form_label_slug'), array('class' => 'col-md-3 control-label')); !!}
  <div class="col-md-9">
    <div class="input-group">
      {!! Form::text('slug', old('slug'), array('id' => 'slug', 'class' => 'form-control', 'placeholder' => trans('forms.form_ph_slug'))) !!}
      <label class="input-group-addon" for="slug"><i class="fa fa-fw {{ trans('forms.form_icon_slug') }}" aria-hidden="true"></i></label>
    </div>
    @if ($errors->has('slug'))
      <span class="help-block">
          <strong>{{ $errors->first('slug') }}</strong>
      </span>
    @endif
  </div>
</div>

<div class="form-group has-feedback row {{ $errors->has('summary') ? ' has-error ' : '' }}">
  {!! Form::label('summary', trans('forms.form_label_summary') , array('class' => 'col-md-3 control-label')); !!}
  <div class="col-md-9">
    <div class="input-group">
      {!! Form::textarea('summary', old('summary'), array('id' => 'summary', 'class' => 'form-control', 'placeholder' => trans('forms.form_ph_summary'), 'rows' => 3)) !!}
      <label class="input-group-addon" for="summary"><i class="fa fa-fw {{ trans('forms.form_icon_summary') }}" aria-hidden="true"></i></label>
    </div>
    @if ($errors->has('summary'))
      <span class="help-block">
        <strong>{{ $errors->first('summary') }}</strong>
      </span>
    @endif
  </div>
</div>

<div class="form-group has-feedback row {{ $errors->has('content') ? ' has-error ' : '' }}">
  {!! Form::label('content', trans('forms.form_label_content') , array('class' => 'col-md-3 control-label')); !!}
  <div class="col-md-9">
    <div class="input-group">
      {!! Form::textarea('content', old('content'), array('id' => 'content', 'class' => 'form-control elm', 'placeholder' => trans('forms.form_ph_content'))) !!}
    </div>
    @if ($errors->has('content'))
      <span class="help-block">
        <strong>{{ $errors->first('content') }}</strong>
      </span>
    @endif
  </div>
</div>

<div class="form-group has-feedback row {{ $errors->has('image') ? ' has-error ' : '' }}">
  {!! Form::label('image', trans('forms.form_label_image'), array('class' => 'col-md-3 control-label')); !!}
  <div class="col-md-9">
    <div class="input-group">
      {!! Form::text('image', old('image'), array('id' => 'image', 'class' => 'form-control', 'placeholder' => trans('forms.form_ph_image'), 'onchange' => 'GetFilenameFromPath("image", 1)', 'readonly' => true)) !!}
      <a class="input-group-addon btn btn-default" title="Xóa hình" onclick="document.getElementById('image').value = ''"><i class="fa fa-fw fa-times" aria-hidden="true"></i></a>
      <a class="input-group-addon btn btn-primary fancybox" title="Chọn hình" href="/plugins/tinymce/plugins/filemanager/dialog.php?type=1&field_id=image&akey={{ AKEY }}"><i class="fa fa-fw {{ trans('forms.form_icon_image') }}" aria-hidden="true"></i><span class="hidden-xs hidden-sm"> Chọn hình</span></a>
    </div>
    @if ($errors->has('image'))
      <span class="help-block">
          <strong>{{ $errors->first('image') }}</strong>
      </span>
    @endif
  </div>
</div>

<div class="form-group has-feedback row {{ $errors->has('meta_title') ? ' has-error ' : '' }}">
  {!! Form::label('meta_title', trans('forms.form_label_meta_title'), array('class' => 'col-md-3 control-label')); !!}
  <div class="col-md-9">
    <div class="input-group">
      {!! Form::text('meta_title', old('meta_title'), array('id' => 'meta_title', 'class' => 'form-control', 'placeholder' => trans('forms.form_ph_meta_title'))) !!}
      <label class="input-group-addon" for="meta_title"><i class="fa fa-fw {{ trans('forms.form_icon_meta_title') }}" aria-hidden="true"></i></label>
    </div>
    @if ($errors->has('meta_title'))
      <span class="help-block">
          <strong>{{ $errors->first('meta_title') }}</strong>
      </span>
    @endif
  </div>
</div>

<div class="form-group has-feedback row {{ $errors->has('meta_keyword') ? ' has-error ' : '' }}">
  {!! Form::label('meta_keyword', trans('forms.form_label_meta_keyword') , array('class' => 'col-md-3 control-label')); !!}
  <div class="col-md-9">
    <div class="input-group">
      {!! Form::textarea('meta_keyword', old('meta_keyword'), array('id' => 'meta_keyword', 'class' => 'form-control', 'placeholder' => trans('forms.form_ph_meta_keyword'), 'rows' => 3)) !!}
      <label class="input-group-addon" for="meta_keyword"><i class="fa fa-fw {{ trans('forms.form_icon_meta_keyword') }}" aria-hidden="true"></i></label>
    </div>
    @if ($errors->has('meta_keyword'))
      <span class="help-block">
        <strong>{{ $errors->first('meta_keyword') }}</strong>
      </span>
    @endif
  </div>
</div>

<div class="form-group has-feedback row {{ $errors->has('meta_description') ? ' has-error ' : '' }}">
  {!! Form::label('meta_description', trans('forms.form_label_meta_description') , array('class' => 'col-md-3 control-label')); !!}
  <div class="col-md-9">
    <div class="input-group">
      {!! Form::textarea('meta_description', old('meta_description'), array('id' => 'meta_description', 'class' => 'form-control', 'placeholder' => trans('forms.form_ph_meta_description'), 'rows' => 3)) !!}
      <label class="input-group-addon" for="meta_description"><i class="fa fa-fw {{ trans('forms.form_icon_meta_description') }}" aria-hidden="true"></i></label>
    </div>
    @if ($errors->has('meta_description'))
      <span class="help-block">
        <strong>{{ $errors->first('meta_description') }}</strong>
      </span>
    @endif
  </div>
</div>

<div class="form-group has-feedback row {{ $errors->has('meta_image') ? ' has-error ' : '' }}">
  {!! Form::label('meta_image', trans('forms.form_label_meta_image'), array('class' => 'col-md-3 control-label')); !!}
  <div class="col-md-9">
    <div class="input-group">
      {!! Form::text('meta_image', old('meta_image'), array('id' => 'meta_image', 'class' => 'form-control', 'placeholder' => trans('forms.form_ph_meta_image'), 'onchange' => 'GetFilenameFromPath("meta_image")', 'readonly' => true)) !!}
      <a class="input-group-addon btn btn-default" title="Xóa hình" onclick="document.getElementById('meta_image').value = ''"><i class="fa fa-fw fa-times" aria-hidden="true"></i></a>
      <a class="input-group-addon btn btn-primary fancybox" for="meta_image" href="/plugins/tinymce/plugins/filemanager/dialog.php?type=1&field_id=meta_image&akey={{ AKEY }}"><i class="fa fa-fw {{ trans('forms.form_icon_image') }}" aria-hidden="true"></i><span class="hidden-xs hidden-sm"> Chọn hình</span></a>
    </div>
    @if ($errors->has('meta_image'))
      <span class="help-block">
          <strong>{{ $errors->first('meta_image') }}</strong>
      </span>
    @endif
  </div>
</div>

<div class="form-group has-feedback row {{ $errors->has('lang') ? ' has-error ' : '' }} hidden">
  {!! Form::label('lang', trans('forms.form_label_lang'), array('class' => 'col-md-3 control-label')); !!}
  <div class="col-md-9">
    <div class="input-group">
      <select class="form-control" name="lang" id="lang">
        @php
          $langArray = CommonOption::langArray();
          $lang = !empty(old('lang')) ? old('lang') : $data->lang;
        @endphp
        @if ($langArray)
          @foreach($langArray as $key => $value)
            <option value="{{ $key }}" {{ $lang == $key ? 'selected="selected"' : '' }}>{{ $value }}</option>
          @endforeach
        @endif
      </select>
      <label class="input-group-addon" for="lang"><i class="fa fa-fw {{ trans('forms.form_icon_lang') }}" aria-hidden="true"></i></label>
    </div>
    @if ($errors->has('lang'))
      <span class="help-block">
          <strong>{{ $errors->first('lang') }}</strong>
      </span>
    @endif
  </div>
</div>

@php
    $status = !empty(old('status')) ? old('status') : $data->status;

    $dataActive = [
    'checked' => '',
    'value' => 0,
    'true'  => '',
    'false' => 'checked'
    ];

    if($status == 1) {
        $dataActive = [
          'checked' => 'checked',
          'value' => 1,
      'true'  => 'checked',
      'false' => ''
        ];
    }

@endphp

<div class="form-group has-feedback row {{ $errors->has('status') ? ' has-error ' : '' }}">
  {!! Form::label('status', trans('forms.statusLabel'), array('class' => 'col-md-3 control-label')); !!}
  <div class="col-md-9">
    <label class="switch {{ $dataActive['checked'] }}" for="status">
      <span class="active"><i class="fa fa-toggle-on fa-2x"></i> {{ trans('forms.statusEnabled') }}</span>
      <span class="inactive"><i class="fa fa-toggle-on fa-2x fa-rotate-180"></i> {{ trans('forms.statusDisabled') }}</span>
      <input type="radio" name="status" value="1" {{ $dataActive['true'] }}>
      <input type="radio" name="status" value="2" {{ $dataActive['false'] }}>
    </label>

    @if ($errors->has('status'))
      <span class="help-block">
        <strong>{{ $errors->first('status') }}</strong>
      </span>
    @endif
  </div>
</div>

<div class="form-group has-feedback row {{ $errors->has('start_date') ? ' has-error ' : '' }}">
  {!! Form::label('start_date', trans('forms.form_label_start_date'), array('class' => 'col-md-3 control-label')); !!}
  <div class="col-md-9">
    <div class="input-group date">
      {!! Form::text('start_date', old('start_date'), array('id' => 'start_date', 'class' => 'form-control', 'placeholder' => trans('forms.form_ph_start_date'))) !!}
      <label class="input-group-addon" for="start_date"><i class="fa fa-fw {{ trans('forms.form_icon_start_date') }}" aria-hidden="true"></i></label>
    </div>
    @if ($errors->has('start_date'))
      <span class="help-block">
          <strong>{{ $errors->first('start_date') }}</strong>
      </span>
    @endif
  </div>
</div>

@include('scripts.slug')
@include('scripts.tinymce')
@include('scripts.toggleStatus')
@include('scripts.datetimepicker')
