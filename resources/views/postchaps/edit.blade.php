@extends('layouts.app')

@section('template_title')
  Editing Post Chap {{ $data->name }}
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
                $post = CommonQuery::getAllFields('posts', $data->post_id, ['name', 'slug']);
                $postName = isset($post)?$post->name:null;
                $postSlug = isset($post)?$post->slug:null;
            @endphp

            <strong>Editing Post Chap: </strong>
            <a href="{{ url($data->slug) }}" target="_blank">{{ str_limit($data->name, 15) }}</a>
            @if(isset($postName))
             / <a href="{{ url($postSlug) }}" target="_blank">{{ str_limit($postName, 15) }}</a>
            @endif

            <a href="{{ URL::to('postchaps/?post_id=' . $data->post_id) }}" class="btn btn-primary btn-xs pull-right margin-left-1">
              <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
              Back <span class="hidden-xs">to</span><span class="hidden-xs"> Post Chaps</span>
            </a>

            <a href="/posts" class="btn btn-info btn-xs pull-right">
              <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
              Back <span class="hidden-xs">to</span><span class="hidden-xs"> Posts</span>
            </a>

          </div>

          {!! Form::model($data, array('action' => array('PostChapsController@update', $data->id), 'method' => 'PUT')) !!}

            {!! csrf_field() !!}

            <div class="panel-body">

              @include('partials.form-content-edit')

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