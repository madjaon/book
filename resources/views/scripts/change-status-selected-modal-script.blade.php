<script type="text/javascript">
	$(document).ready(function(){

		// CONFIRMATION MODAL
		$('#modalChangeStatusSelected').on('show.bs.modal', function (e) {
			var message = $(e.relatedTarget).attr('data-message');
			var title = $(e.relatedTarget).attr('data-title');
			var form = $(e.relatedTarget).closest('form');
			$(this).find('.modal-body p').text(message);
			$(this).find('.modal-title').text(title);
			$(this).find('.modal-footer #confirmChangeStatusSelected').data('form', form);
		});
		$('#modalChangeStatusSelected').find('.modal-footer #confirmChangeStatusSelected').on('click', function(){
		  	actionSelected('posts', 1)
		});
		
	});

</script>