@extends('layouts.app')

@section('template_title')
  Create New Post Seri
@endsection

@section('template_fastload_css')
@endsection

@section('content')

  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            
            Create New Post Seri

            <a href="/postseries" class="btn btn-info btn-xs pull-right">
              <i class="fa fa-fw fa-mail-reply" aria-hidden="true"></i>
              Back <span class="hidden-xs">to</span><span class="hidden-xs"> Post Series</span>
            </a>

          </div>
          <div class="panel-body">

            {!! Form::open(array('action' => 'PostSeriesController@store')) !!}

              @include('partials.form-content-create')

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
