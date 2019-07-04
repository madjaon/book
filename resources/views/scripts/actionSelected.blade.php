<script type="text/javascript">
	//update status selected: 1
	//call update type selected: 2
	//delete selected: 3
	function actionSelected(obj, action)
	{
		var check = $('input:checkbox:checked.id').val();
		if(check) {
			if(action == 1) {
				callUpdateStatus(obj, 'status');
			} else if(action == 2) {
				callUpdateTypeBox(obj);
			} else {
				callDelete(obj);
			}
		} else {
			alert('Bạn chưa chọn item nào!');
		}
	}
	function callUpdateStatus(obj, field)
	{
		url = window.location.origin + '/' + obj + '/callUpdateStatus';
		var id = $('input:checkbox:checked.id').map(function () {
		  	return this.value;
		}).get();
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
	            $('#loadMsg1').html('Working...');
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
	//call delete selected
	function callDelete(obj)
	{
		url = window.location.origin + '/' + obj + '/callDelete';
		var id = $('input:checkbox:checked.id').map(function () {
		  	return this.value;
		}).get();
		$.ajax(
		{
			type: 'post',
			url: url,
			data: {
				'id': id,
				'_token': '{{ csrf_token() }}'
			},
			beforeSend: function() {
	            $('#loadMsg3').html('Working...');
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
	function callUpdateTypeBox(obj)
	{
		$('#modalPostTypeSelect').modal('toggle');
	}
	function callUpdateType(obj)
	{
		url = window.location.origin + '/' + obj + '/callUpdateType';
		var id = $('input:checkbox:checked.id').map(function () {
		  	return this.value;
		}).get();
		var posttype_id = $('input:checkbox:checked.posttype_id').map(function () {
		  	return this.value;
		}).get();
		var type_main_id = $('input[name="type_main_id"]').val();
		//validate
		if(id.length <= 0 || posttype_id.length <= 0 || type_main_id == '') {
			alert('Bạn chưa chọn đầy đủ các mục!');
			$('#modalPostTypeSelect').modal('hide');
			window.location.reload();
		} else {
			$.ajax(
			{
				type: 'post',
				url: url,
				data: {
					'id': id,
					'posttype_id': posttype_id,
					'type_main_id': type_main_id,
					'_token': '{{ csrf_token() }}'
				},
				beforeSend: function() {
					$('#loadMsg3').html('Working...');
		            $('#confirmPostTypeSelect').prop('disabled', true);
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
	}
	function callUpdatePosition(obj)
	{
		url = window.location.origin + '/' + obj + '/callUpdatePosition';
		var id = $('input:checkbox.id').map(function () {
		  	return this.value;
		}).get();
		var position = $('input[name^="position"]').map(function () {
		  	return this.value;
		}).get();
		$.ajax(
		{
			type: 'post',
			url: url,
			data: {
				'id': id,
				'position': position,
				'_token': '{{ csrf_token() }}'
			},
			beforeSend: function() {
	            $('#loadMsg4').html('Working...');
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