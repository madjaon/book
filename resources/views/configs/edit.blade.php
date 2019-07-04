@extends('layouts.app')

@section('template_title')
  Editing Configs
@endsection

@section('template_fastload_css')
@endsection

@section('content')

  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-default">
          <div class="panel-heading">

            Editing Configs
            
          </div>

          {!! Form::model($data, array('action' => array('ConfigsController@update', $data->id), 'method' => 'PUT')) !!}

            {!! csrf_field() !!}

            <div class="panel-body">

              <div class="form-group has-feedback row {{ $errors->has('headercode') ? ' has-error ' : '' }}">
                {!! Form::label('headercode', trans('forms.form_label_headercode') , array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                  <div class="input-group">
                    {!! Form::textarea('headercode', old('headercode'), array('id' => 'headercode', 'class' => 'form-control', 'placeholder' => trans('forms.form_ph_headercode'), 'rows' => 3)) !!}
                    <label class="input-group-addon" for="headercode"><i class="fa fa-fw {{ trans('forms.form_icon_headercode') }}" aria-hidden="true"></i></label>
                  </div>
                  @if ($errors->has('headercode'))
                    <span class="help-block">
                      <strong>{{ $errors->first('headercode') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group has-feedback row {{ $errors->has('footercode') ? ' has-error ' : '' }}">
                {!! Form::label('footercode', trans('forms.form_label_footercode') , array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                  <div class="input-group">
                    {!! Form::textarea('footercode', old('footercode'), array('id' => 'footercode', 'class' => 'form-control', 'placeholder' => trans('forms.form_ph_footercode'), 'rows' => 3)) !!}
                    <label class="input-group-addon" for="footercode"><i class="fa fa-fw {{ trans('forms.form_icon_footercode') }}" aria-hidden="true"></i></label>
                  </div>
                  @if ($errors->has('footercode'))
                    <span class="help-block">
                      <strong>{{ $errors->first('footercode') }}</strong>
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

              <div class="form-group has-feedback row {{ $errors->has('fb_app_id') ? ' has-error ' : '' }}">
                {!! Form::label('fb_app_id', trans('forms.form_label_fb_app_id'), array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                  <div class="input-group">
                    {!! Form::text('fb_app_id', old('fb_app_id'), array('id' => 'fb_app_id', 'class' => 'form-control', 'placeholder' => trans('forms.form_ph_fb_app_id'))) !!}
                    <label class="input-group-addon" for="fb_app_id"><i class="fa fa-fw {{ trans('forms.form_icon_fb_app_id') }}" aria-hidden="true"></i></label>
                  </div>
                  @if ($errors->has('fb_app_id'))
                    <span class="help-block">
                        <strong>{{ $errors->first('fb_app_id') }}</strong>
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

@endsection