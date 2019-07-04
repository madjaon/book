<div class="modal fade" id="modalPostTypeSelect" role="dialog" aria-labelledby="modalPostTypeSelectLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">
          {{ trans('forms.form_label_category') }}
        </h4>
      </div>
      <div class="modal-body">
        <p><strong>Lưu ý:</strong> Click chọn thể loại chính (primary). Click lại nếu (primary) ẩn.</p>
        @include('posts.form-type')
      </div>
      <div class="modal-footer">
        {!! Form::button('<i class="fa fa-fw fa-close" aria-hidden="true"></i> ' . trans('modals.form_modal_default_btn_cancel'), array('class' => 'btn pull-left', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
        {!! Form::button('<i class="fa fa-fw fa-check" aria-hidden="true"></i> ' . trans('modals.form_modal_default_btn_submit'), array('class' => 'btn btn-default pull-right', 'type' => 'button', 'id' => 'confirmPostTypeSelect', 'data-toggle' => 'modal', 'data-target' => '#modalChangeCategorySelected', 'data-title' => 'Change Category Selected Items', 'data-message' => 'Are you sure you want to change category selected items ?' )) !!}
      </div>
    </div>
  </div>
</div>