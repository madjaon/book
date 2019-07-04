@extends('layouts.app')

@section('template_title')
  Editing Post {{ $data->name }}
@endsection

@section('template_fastload_css')
@endsection

@section('content')

  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-default">
          <div class="panel-heading">

            <strong>Editing Post: </strong>
            <a href="{{ url($data->slug) }}" target="_blank">{{ str_limit($data->name, 30) }}</a>

            <a href="/posts" class="btn btn-info btn-xs pull-right">
              <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
              <span class="hidden-xs">Back to </span>Posts
            </a>

          </div>

          {!! Form::model($data, array('action' => array('PostsController@update', $data->id), 'method' => 'PUT')) !!}

            {!! csrf_field() !!}

            <div class="panel-body">

              @include('partials.form-content-edit')

              @include('posts.form-typeseritag-edit')

              <div class="form-group has-feedback row {{ $errors->has('type') ? ' has-error ' : '' }}">
                {!! Form::label('type', trans('forms.form_label_type'), array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                  <div class="input-group">
                    <select class="form-control" name="type" id="type">
                      <!-- <option value="">{{ trans('forms.form_ph_type') }}</option> -->
                      @php
                        $typeArray = CommonOption::typeArray();
                        $type = !empty(old('type')) ? old('type') : $data->type;
                      @endphp
                      @if ($typeArray)
                        @foreach($typeArray as $key => $value)
                          <option value="{{ $key }}" {{ $type == $key ? 'selected="selected"' : '' }}>{{ $value }}</option>
                        @endforeach
                      @endif
                    </select>
                    <label class="input-group-addon" for="type"><i class="fa fa-fw {{ trans('forms.form_icon_type') }}" aria-hidden="true"></i></label>
                  </div>
                  @if ($errors->has('type'))
                    <span class="help-block">
                        <strong>{{ $errors->first('type') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group has-feedback row {{ $errors->has('nation') ? ' has-error ' : '' }}">
                {!! Form::label('nation', trans('forms.form_label_nation'), array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                  <div class="input-group">
                    <select class="form-control" name="nation" id="nation">
                      <!-- <option value="">{{ trans('forms.form_ph_nation') }}</option> -->
                      @php
                        $nationArray = CommonOption::nationArray();
                        $nation = !empty(old('nation')) ? old('nation') : $data->nation;
                      @endphp
                      @if ($nationArray)
                        @foreach($nationArray as $key => $value)
                          <option value="{{ $key }}" {{ $nation == $key ? 'selected="selected"' : '' }}>{{ $value }}</option>
                        @endforeach
                      @endif
                    </select>
                    <label class="input-group-addon" for="nation"><i class="fa fa-fw {{ trans('forms.form_icon_nation') }}" aria-hidden="true"></i></label>
                  </div>
                  @if ($errors->has('nation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('nation') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group has-feedback row {{ $errors->has('kind') ? ' has-error ' : '' }}">
                {!! Form::label('kind', trans('forms.form_label_kind'), array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                  <div class="input-group">
                    <select class="form-control" name="kind" id="kind">
                      <!-- <option value="">{{ trans('forms.form_ph_kind') }}</option> -->
                      @php
                        $kindArray = CommonOption::kindArray();
                        $kind = !empty(old('kind')) ? old('kind') : $data->kind;
                      @endphp
                      @if ($kindArray)
                        @foreach($kindArray as $key => $value)
                          <option value="{{ $key }}" {{ $kind == $key ? 'selected="selected"' : '' }}>{{ $value }}</option>
                        @endforeach
                      @endif
                    </select>
                    <label class="input-group-addon" for="kind"><i class="fa fa-fw {{ trans('forms.form_icon_kind') }}" aria-hidden="true"></i></label>
                  </div>
                  @if ($errors->has('kind'))
                    <span class="help-block">
                        <strong>{{ $errors->first('kind') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group has-feedback row {{ $errors->has('gallery') ? ' has-error ' : '' }}">
                {!! Form::label('gallery', trans('forms.form_label_gallery'), array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                  
                  @include('posts.form-images', array('isedit' => true, 'data' => $data))
                  
                  @if ($errors->has('kind'))
                    <span class="help-block">
                        <strong>{{ $errors->first('kind') }}</strong>
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

@endsection