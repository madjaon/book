<script type="text/javascript">
	function updateStatus(obj, id, field)
	{
		url = window.location.origin + '/' + obj + '/updateStatus';
		$.ajax(
		{
			type: 'post',
			url: url,
			data: {
				'id': id,
				'field': field,
				'_token': '{{ csrf_token() }}'
			},
			beforeSend: function() {
	            $('#'+field+'_'+id).html('...');
	        },
			success: function(data)
			{
				window.location.reload();
			},
			error: function(xhr)
			{
				alert("An error occured: " + xhr.status + " " + xhr.statusText);
				window.location.reload();
			}
		});
	}
</script>