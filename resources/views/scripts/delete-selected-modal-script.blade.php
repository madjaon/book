<script type="text/javascript">
	$(document).ready(function(){

		// CONFIRMATION DELETE MODAL
		$('#modalDeleteSelected').on('show.bs.modal', function (e) {
			var message = $(e.relatedTarget).attr('data-message');
			var title = $(e.relatedTarget).attr('data-title');
			var form = $(e.relatedTarget).closest('form');
			$(this).find('.modal-body p').text(message);
			$(this).find('.modal-title').text(title);
			$(this).find('.modal-footer #confirmDeleteSelected').data('form', form);
		});
		$('#modalDeleteSelected').find('.modal-footer #confirmDeleteSelected').on('click', function(){
		  	actionSelected('posts', 3);
		});
		
	});

</script>