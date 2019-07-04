@extends('layouts.app')

@section('template_title')
  Upload multiple images from Links list
@endsection

@section('template_fastload_css')
@endsection

@section('content')

  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            
            Upload multiple images from urls

          </div>
          <div class="panel-body">

            {!! Form::open(array('action' => 'CrawlerController@uploadImagesAction')) !!}

              <div class="form-group has-feedback row {{ $errors->has('folder') ? ' has-error ' : '' }}">
                {!! Form::label('folder', trans('forms.form_label_folder'), array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                  <div class="input-group">
                    {!! Form::text('folder', old('folder'), array('id' => 'folder', 'class' => 'form-control', 'placeholder' => trans('forms.form_ph_folder'))) !!}
                    <label class="input-group-addon" for="folder"><i class="fa fa-fw {{ trans('forms.form_icon_folder') }}" aria-hidden="true"></i></label>
                  </div>
                  @if ($errors->has('folder'))
                    <span class="help-block">
                        <strong>{{ $errors->first('folder') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group has-feedback row {{ $errors->has('urls') ? ' has-error ' : '' }}">
                {!! Form::label('urls', trans('forms.form_label_urls') , array('class' => 'col-md-3 control-label')); !!}
                <div class="col-md-9">
                  <div class="input-group">
                    {!! Form::textarea('urls', old('urls'), array('id' => 'urls', 'class' => 'form-control', 'placeholder' => trans('forms.form_ph_urls'), 'rows' => 6)) !!}
                    <label class="input-group-addon" for="urls"><i class="fa fa-fw {{ trans('forms.form_icon_urls') }}" aria-hidden="true"></i></label>
                  </div>
                  @if ($errors->has('urls'))
                    <span class="help-block">
                      <strong>{{ $errors->first('urls') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              {!! Form::button('<i class="fa fa-upload" aria-hidden="true"></i>&nbsp;' . trans('forms.form_button_upload_text'), array('class' => 'btn btn-success btn-flat margin-bottom-1 pull-right','type' => 'submit', )) !!}

              {!! Form::button('<i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;' . trans('forms.form_button_reset_text'), array('class' => 'btn btn-default btn-flat margin-bottom-1 pull-right margin-right-1','type' => 'reset', )) !!}

            {!! Form::close() !!}

          </div>
          
          <div class="panel-footer">
            
            <p>Folder: Tên thư mục chứa ảnh. Không dấu, in thường, có thể sử dụng _ hoặc -. ex: ten_thu_muc hoặc tenthumuc/tenthumuc2 ...</p>
            <p>Urls: Danh sách link ảnh (jpg,jpeg,png). Mỗi link một dòng.</p>

          </div>

        </div>
      </div>
    </div>
  </div>

@endsection

@section('footer_scripts')
@endsection
