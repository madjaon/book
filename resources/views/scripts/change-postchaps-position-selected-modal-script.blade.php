<script type="text/javascript">
	$(document).ready(function(){

		// CONFIRMATION MODAL
		$('#modalPostChapsChangePositionSelected').on('show.bs.modal', function (e) {
			var message = $(e.relatedTarget).attr('data-message');
			var title = $(e.relatedTarget).attr('data-title');
			var form = $(e.relatedTarget).closest('form');
			$(this).find('.modal-body p').text(message);
			$(this).find('.modal-title').text(title);
			$(this).find('.modal-footer #confirmPostChapsChangePositionSelected').data('form', form);
		});
		$('#modalPostChapsChangePositionSelected').find('.modal-footer #confirmPostChapsChangePositionSelected').on('click', function(){
		  	callUpdatePosition('postchaps');
		});
		
	});

</script>