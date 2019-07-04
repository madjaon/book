<script type="text/javascript">
	$(document).ready(function(){

		// CONFIRMATION DELETE MODAL
		$('#modalPostChapsDeleteSelected').on('show.bs.modal', function (e) {
			var message = $(e.relatedTarget).attr('data-message');
			var title = $(e.relatedTarget).attr('data-title');
			var form = $(e.relatedTarget).closest('form');
			$(this).find('.modal-body p').text(message);
			$(this).find('.modal-title').text(title);
			$(this).find('.modal-footer #confirmPostChapsDeleteSelected').data('form', form);
		});
		$('#modalPostChapsDeleteSelected').find('.modal-footer #confirmPostChapsDeleteSelected').on('click', function(){
		  	actionSelected('postchaps', 3);
		});
		
	});

</script>