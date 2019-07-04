@extends('layouts.app')

@section('template_title')
  Editing Ad {{ $data->id }}
@endsection

@section('template_fastload_css')
@endsection

@section('content')

  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-default">
          <div class="panel-heading">

            <strong>Editing Ad: </strong> {{ $data->id }}

            <a href="/ads" class="btn btn-info btn-xs pull-right">
              <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
              Back <span class="hidden-xs">to</span><span class="hidden-xs"> Ads</span>
            </a>

          </div>

          {!! Form::model($data, array('action' => array('AdsController@update', $data->id), 'method' => 'PUT')) !!}

            {!! csrf_field() !!}

            <div class="panel-body">

              <div class="form-group has-feedback row {{ $errors->has('name') ? ' has-error ' : '' }}">
                {!! Form::label('name', trans('forms.form_label_name'), array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                  <div class="input-group">
                    {!! Form::text('name', old('name'), array('id' => 'name', 'class' => 'form-control', 'placeholder' => trans('forms.form_ph_name'))) !!}
                    <label class="input-group-addon" for="name"><i class="fa fa-fw {{ trans('forms.form_icon_name') }}" aria-hidden="true"></i></label>
                  </div>
                  @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group has-feedback row {{ $errors->has('position') ? ' has-error ' : '' }}">
                {!! Form::label('position', trans('forms.form_label_position'), array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                  <div class="input-group">
                    <select class="form-control" name="position" id="position">
                      @php
                        $positionArray = CommonOption::positionArray();
                        $position = !empty(old('position')) ? old('position') : $data->position;
                      @endphp
                      @if ($positionArray)
                        @foreach($positionArray as $key => $value)
                          <option value="{{ $key }}" {{ $position == $key ? 'selected="selected"' : '' }}>{{ $value }}</option>
                        @endforeach
                      @endif
                    </select>
                    <label class="input-group-addon" for="position"><i class="fa fa-fw {{ trans('forms.form_icon_position') }}" aria-hidden="true"></i></label>
                  </div>
                  @if ($errors->has('position'))
                    <span class="help-block">
                        <strong>{{ $errors->first('position') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group has-feedback row {{ $errors->has('code') ? ' has-error ' : '' }}">
                {!! Form::label('code', trans('forms.form_label_code') , array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                  <div class="input-group">
                    {!! Form::textarea('code', old('code'), array('id' => 'code', 'class' => 'form-control', 'placeholder' => trans('forms.form_ph_code'), 'rows' => 3)) !!}
                    <label class="input-group-addon" for="code"><i class="fa fa-fw {{ trans('forms.form_icon_code') }}" aria-hidden="true"></i></label>
                  </div>
                  @if ($errors->has('code'))
                    <span class="help-block">
                      <strong>{{ $errors->first('code') }}</strong>
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
                    <a class="input-group-addon btn btn-primary fancybox" for="image" href="/plugins/tinymce/plugins/filemanager/dialog.php?type=1&field_id=image&akey={{ AKEY }}"><i class="fa fa-fw {{ trans('forms.form_icon_image') }}" aria-hidden="true"></i><span class="hidden-xs hidden-sm"> Chọn hình</span></a>
                  </div>
                  @if ($errors->has('image'))
                    <span class="help-block">
                        <strong>{{ $errors->first('image') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group has-feedback row {{ $errors->has('url') ? ' has-error ' : '' }}">
                {!! Form::label('url', trans('forms.form_label_url'), array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                  <div class="input-group">
                    {!! Form::text('url', old('url'), array('id' => 'url', 'class' => 'form-control', 'placeholder' => trans('forms.form_ph_url'))) !!}
                    <label class="input-group-addon" for="url"><i class="fa fa-fw {{ trans('forms.form_icon_url') }}" aria-hidden="true"></i></label>
                  </div>
                  @if ($errors->has('url'))
                    <span class="help-block">
                        <strong>{{ $errors->first('url') }}</strong>
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
                {!! Form::label('status', trans('forms.statusLabel') , array('class' => 'col-md-3 control-label')); !!}
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

              <div class="form-group has-feedback row {{ $errors->has('end_date') ? ' has-error ' : '' }}">
                {!! Form::label('end_date', trans('forms.form_label_end_date'), array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                  <div class="input-group date">
                    {!! Form::text('end_date', old('end_date'), array('id' => 'end_date', 'class' => 'form-control', 'placeholder' => trans('forms.form_ph_end_date'))) !!}
                    <label class="input-group-addon" for="end_date"><i class="fa fa-fw {{ trans('forms.form_icon_end_date') }}" aria-hidden="true"></i></label>
                  </div>
                  @if ($errors->has('end_date'))
                    <span class="help-block">
                        <strong>{{ $errors->first('end_date') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

            </div>
            <div class="panel-footer">

              <div class="row">

                <div class="col-xs-6">
                  {!! Form::button('<i class="fa fa-fw fa-save" aria-hidden="true"></i>' . trans('forms.form_button_edit_text'), array('class' => 'btn btn-success btn-block margin-bottom-1 btn-save','type' => 'button', 'data-toggle' => 'modal', 'data-target' => '#confirmSave', 'data-title' => Lang::get('modals.edit_user__modal_text_confirm_title'), 'data-message' => Lang::get('modals.edit_user__modal_text_confirm_message'))) !!}
                </div>

                <div class="col-xs-6">
                  {!! Form::button('<i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;' . trans('forms.form_button_reset_text'), array('class' => 'btn btn-default btn-block margin-bottom-1','type' => 'reset', )) !!}
                </div>
              </div>

              @include('partials.image-note')
              
              <p>Ưu tiên sử dụng mã Code (trường hợp nếu có hình + đường dẫn)</p>

            </div>

          {!! Form::close() !!}

        </div>
      </div>
    </div>
  </div>

  @include('modals.modal-save')

@endsection

@section('footer_scripts')

  @include('scripts.save-modal-script')
  @include('scripts.tinymce')
  @include('scripts.toggleStatus')
  @include('scripts.datetimepicker')

@endsection