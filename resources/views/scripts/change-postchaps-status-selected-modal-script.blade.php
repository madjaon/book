<script type="text/javascript">
	$(document).ready(function(){

		// CONFIRMATION MODAL
		$('#modalPostChapsChangeStatusSelected').on('show.bs.modal', function (e) {
			var message = $(e.relatedTarget).attr('data-message');
			var title = $(e.relatedTarget).attr('data-title');
			var form = $(e.relatedTarget).closest('form');
			$(this).find('.modal-body p').text(message);
			$(this).find('.modal-title').text(title);
			$(this).find('.modal-footer #confirmPostChapsChangeStatusSelected').data('form', form);
		});
		$('#modalPostChapsChangeStatusSelected').find('.modal-footer #confirmPostChapsChangeStatusSelected').on('click', function(){
		  	actionSelected('postchaps', 1)
		});
		
	});

</script>