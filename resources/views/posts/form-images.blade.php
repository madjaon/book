@if(!isset($isedit))
<div class="form-group has-feedback">
	<div class="postimage">
		<p><strong id="postimage_num">0</strong> ảnh. <a href="{{ url('uploadimages') }}" target="_blank">Click here to open tab multi upload from urls</a></p>
		<ul id="ul_images">
			<li id="li_images_0">
				<input name="images[]" type="hidden" value="" id="post_images_0" onchange="GetFilenameFromPathPostImage('post_images_0');" />
				<img class="post_images_0" />
				<a tabindex="1" href="/plugins/tinymce/plugins/filemanager/dialog.php?type=1&field_id=post_images_0&akey={{ AKEY }}" class="fancybox postimage-select" title="Select Image">Select</a>
				<a onclick="deleteImage('li_images_0');" class="postimage-delete" title="Delete"><i class="fa fa-times"></i></a>
			</li>
		</ul>
	</div>
</div>
@else
@php
	if(!empty($data->images)) {
	  $post_images = explode(',', $data->images);
	  $count_post_images = count($post_images);
	} else {
	  $count_post_images = 0;
	}
@endphp
<div class="form-group has-feedback">
	<div class="postimage">
		<p><strong id="postimage_num">{{ $count_post_images }}</strong> ảnh. <a href="{{ url('uploadimages') }}" target="_blank">Click here to open tab multi upload from urls</a></p>
		<ul id="ul_images">
			@if($count_post_images > 0)
			@foreach($post_images as $key => $value)
			<li id="li_images_{{ $key }}">
				<input name="images[]" type="hidden" value="{{ $value }}" id="post_images_{{ $key }}" onchange="GetFilenameFromPathPostImage('post_images_{{ $key }}');" />
				<img src="{{ CommonMethod::getThumbnail($value, 3) }}" class="post_images_{{ $key }}" />
				<a tabindex="1" href="/plugins/tinymce/plugins/filemanager/dialog.php?type=1&field_id=post_images_{{ $key }}&akey={{ AKEY }}" class="fancybox postimage-select" title="Select Image">Select</a>
				<a onclick="deleteImage('li_images_{{ $key }}');" class="postimage-delete" title="Delete"><i class="fa fa-times"></i></a>
			</li>
			@endforeach
			@endif
			<li id="li_images_{{ $count_post_images }}">
				<input name="images[]" type="hidden" value="" id="post_images_{{ $count_post_images }}" onchange="GetFilenameFromPathPostImage('post_images_{{ $count_post_images }}');" />
				<img class="post_images_{{ $count_post_images }}" />
				<a tabindex="1" href="/plugins/tinymce/plugins/filemanager/dialog.php?type=1&field_id=post_images_{{ $count_post_images }}&akey={{ AKEY }}" class="fancybox postimage-select" title="Select Image">Select</a>
				<a onclick="deleteImage('li_images_{{ $count_post_images }}');" class="postimage-delete" title="Delete"><i class="fa fa-times"></i></a>
			</li>
		</ul>
	</div>
</div>
@endif

<script>
	function GetFilenameFromPathPostImage(id)
	{
	    var filePath = $('#'+id).val();
	    var first_url = filePath.substring(0,filePath.lastIndexOf("/")+1);
	    var last_url = filePath.substring(filePath.lastIndexOf("/")+1);
    	$('#'+id).val(first_url + last_url);
    	$('.'+id).prop('src', first_url + last_url);
    	//get last id
    	var last_li_id = $('#ul_images li:last-child').prop('id');
    	var last_num = getNum(last_li_id);
    	var next_num = last_num + 1;
    	var id_num = getNum(id);
    	if(id_num === last_num) {
    		addLi(next_num);
    	}
    	updateNum();
	}

	function deleteImage(id)
	{
		//get last id
		var last_li_id = $('#ul_images li:last-child').prop('id');
    	var last_num = getNum(last_li_id);
    	//get delete id
    	var id_num = getNum(id);
    	if(id_num !== last_num) {
    		$('#'+id).slideUp("normal", function() { $(this).remove(); } );
    		updateNum(true);
    	}
    	return;
	}
	function addLi(key)
	{
		var akey = "{{ AKEY }}";
		var li = '<li id="li_images_'+key+'"><input name="images[]" type="hidden" value="" id="post_images_'+key+'" onchange="GetFilenameFromPathPostImage(\'post_images_'+key+'\');" /><img class="post_images_'+key+'" /><a tabindex="1" href="/plugins/tinymce/plugins/filemanager/dialog.php?type=1&field_id=post_images_'+key+'&akey='+akey+'" class="fancybox postimage-select" title="Select Image">Select</a><a onclick="deleteImage(\'li_images_'+key+'\');" class="postimage-delete" title="Delete"><i class="fa fa-times"></i></a></li>';
		$('#ul_images').append(li);
		return false;
	}
	// id: li_images_0 / post_images_0
	function getNum(id)
	{
		var res = id.split("_");
    	var num = parseInt(res[2]);
    	return num;
	}
	//update number post images
	function updateNum(isDelete=false)
	{
		//total post images
    	var li_num = $("#ul_images").children('li').length;
    	if(isDelete === true) {
    		var postimage_num = parseInt(li_num) - 2;
    	} else {
    		var postimage_num = parseInt(li_num) - 1;
    	}
    	$('#postimage_num').text(postimage_num);
    	return;
	}
</script>
<style>
	.postimage ul {
		padding: 0;
	}
	.postimage ul li {
		list-style: none;
	    margin-bottom: 40px;
	    display: inline-block;
	    position: relative;
	    margin-right: 15px;
	}
	.postimage ul li img {
	    width: 80px;
	    height: 80px;
	    display: inline-block;
	}
	a.postimage-select {
		display: inline-block;
	    cursor: pointer;
	    position: absolute;
	    bottom: -25px;
	    left: 0;
	}
	a.postimage-delete {
		display: inline-block;
	    cursor: pointer;
	    color: red;
	    bottom: -25px;
	    position: absolute;
	    right: 0;
	}
</style>