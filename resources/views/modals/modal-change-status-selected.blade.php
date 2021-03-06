<div class="modal fade modal-danger" id="modalChangeStatusSelected" role="dialog" aria-labelledby="modalChangeStatusSelectedLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Confirm Change Status</h4>
      </div>
      <div class="modal-body">
        <p>Change status this items?</p>
      </div>
      <div class="modal-footer">
        {!! Form::button('<i class="fa fa-fw fa-close" aria-hidden="true"></i> ' . trans('modals.form_modal_default_btn_cancel'), array('class' => 'btn btn-outline pull-left btn-flat', 'type' => 'button', 'data-dismiss' => 'modal' )) !!}
        {!! Form::button('<i class="fa fa-fw fa-check" aria-hidden="true"></i> ' . trans('modals.form_modal_default_btn_submit'), array('class' => 'btn btn-danger pull-right btn-flat', 'type' => 'button', 'id' => 'confirmChangeStatusSelected' )) !!}
      </div>
    </div>
  </div>
</div>