@extends('layouts.app')

@section('template_title')
  Create New Post
@endsection

@section('template_fastload_css')
@endsection

@section('content')

  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-default">
          <div class="panel-heading">

            Create New Post

            <a href="/posts" class="btn btn-info btn-xs pull-right">
              <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
              Back <span class="hidden-xs">to</span><span class="hidden-xs"> Posts</span>
            </a>

          </div>
          <div class="panel-body">

            {!! Form::open(array('action' => 'PostsController@store')) !!}

              @include('partials.form-content-create')

              @include('posts.form-typeseritag-create')

              <div class="form-group has-feedback row {{ $errors->has('type') ? ' has-error ' : '' }}">
                {!! Form::label('type', trans('forms.form_label_type'), array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                  <div class="input-group">
                    <select class="form-control" name="type" id="type">
                      <!-- <option value="">{{ trans('forms.form_ph_type') }}</option> -->
                      @php
                        $typeArray = CommonOption::typeArray();
                      @endphp
                      @if ($typeArray)
                        @foreach($typeArray as $key => $value)
                          <option value="{{ $key }}">{{ $value }}</option>
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
                      @endphp
                      @if ($nationArray)
                        @foreach($nationArray as $key => $value)
                          <option value="{{ $key }}">{{ $value }}</option>
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
                      @endphp
                      @if ($kindArray)
                        @foreach($kindArray as $key => $value)
                          <option value="{{ $key }}">{{ $value }}</option>
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
                  
                  @include('posts.form-images')
                  
                  @if ($errors->has('kind'))
                    <span class="help-block">
                        <strong>{{ $errors->first('kind') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              {!! Form::button('<i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp;' . trans('forms.form_button_create_text'), array('class' => 'btn btn-success btn-flat margin-bottom-1 pull-right','type' => 'submit', )) !!}

              {!! Form::button('<i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;' . trans('forms.form_button_reset_text'), array('class' => 'btn btn-default btn-flat margin-bottom-1 pull-right margin-right-1','type' => 'reset', )) !!}

            {!! Form::close() !!}

          </div>
          
          <div class="panel-footer">
            
            @include('partials.image-note')

          </div>

        </div>
      </div>
    </div>
  </div>

@endsection

@section('footer_scripts')
@endsection
