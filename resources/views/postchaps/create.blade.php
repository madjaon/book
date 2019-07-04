@extends('layouts.app')

@section('template_title')
  Create New Post Chap
@endsection

@section('template_fastload_css')
@endsection

@section('content')

  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            
            @php
                $post = CommonQuery::getAllFields('posts', $request->post_id, ['name', 'slug']);
                $postName = isset($post)?$post->name:null;
                $postSlug = isset($post)?$post->slug:null;
            @endphp

            <strong>Create New Post Chap: </strong>
            @if(isset($postName))
            <a href="{{ url($postSlug) }}" target="_blank">{{ str_limit($postName, 30) }}</a>
            @endif

            <a href="{{ URL::to('postchaps/?post_id=' . $request->post_id) }}" class="btn btn-primary btn-xs pull-right margin-left-1">
              <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
              Back <span class="hidden-xs">to</span><span class="hidden-xs"> Post Chaps</span>
            </a>

            <a href="/posts" class="btn btn-info btn-xs pull-right">
              <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
              Back <span class="hidden-xs">to</span><span class="hidden-xs"> Posts</span>
            </a>

          </div>
          <div class="panel-body">

            {!! Form::open(array('action' => 'PostChapsController@store')) !!}

              @include('partials.form-content-create')

              <div class="form-group has-feedback row {{ $errors->has('chapter') ? ' has-error ' : '' }}">
                {!! Form::label('chapter', trans('forms.form_label_chapter'), array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                  <div class="input-group">
                    {!! Form::text('chapter', old('chapter'), array('id' => 'chapter', 'class' => 'form-control', 'placeholder' => trans('forms.form_ph_chapter'))) !!}
                    <label class="input-group-addon" for="chapter"><i class="fa fa-fw {{ trans('forms.form_icon_chapter') }}" aria-hidden="true"></i></label>
                  </div>
                  @if ($errors->has('chapter'))
                    <span class="help-block">
                        <strong>{{ $errors->first('chapter') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group has-feedback row {{ $errors->has('volume') ? ' has-error ' : '' }}">
                {!! Form::label('volume', trans('forms.form_label_volume'), array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                  <div class="input-group">
                    {!! Form::text('volume', old('volume'), array('id' => 'volume', 'class' => 'form-control', 'placeholder' => trans('forms.form_ph_volume'))) !!}
                    <label class="input-group-addon" for="volume"><i class="fa fa-fw {{ trans('forms.form_icon_volume') }}" aria-hidden="true"></i></label>
                  </div>
                  @if ($errors->has('volume'))
                    <span class="help-block">
                        <strong>{{ $errors->first('volume') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              {!! Form::hidden('post_id', $request->post_id) !!}

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
