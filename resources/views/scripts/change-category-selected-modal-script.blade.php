<script type="text/javascript">
	$(document).ready(function(){

		// CONFIRMATION MODAL
		$('#modalChangeCategorySelected').on('show.bs.modal', function (e) {
			var message = $(e.relatedTarget).attr('data-message');
			var title = $(e.relatedTarget).attr('data-title');
			var form = $(e.relatedTarget).closest('form');
			$(this).find('.modal-body p').text(message);
			$(this).find('.modal-title').text(title);
			$(this).find('.modal-footer #confirmChangeCategorySelected').data('form', form);
			$('#modalPostTypeSelect').modal('hide');
		});
		$('#modalChangeCategorySelected').find('.modal-footer #confirmChangeCategorySelected').on('click', function(){
		  	callUpdateType("posts");
		});
		
	});

</script>