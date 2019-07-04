@extends('layouts.app')

@section('template_title')
  Editing Post Tag {{ $data->name }}
@endsection

@section('template_fastload_css')
@endsection

@section('content')

  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-default">
          <div class="panel-heading">

            <strong>Editing Post Tag: </strong>
            <a href="{{ url($data->slug) }}" target="_blank">{{ str_limit($data->name, 30) }}</a>

            <a href="/posttags" class="btn btn-info btn-xs pull-right">
              <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
              Back <span class="hidden-xs">to</span><span class="hidden-xs"> Post Tags</span>
            </a>

          </div>

          {!! Form::model($data, array('action' => array('PostTagsController@update', $data->id), 'method' => 'PUT')) !!}

            {!! csrf_field() !!}

            <div class="panel-body">

              @include('partials.form-content-edit')

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