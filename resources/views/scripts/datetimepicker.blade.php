<script type="text/javascript" src="/plugins/moment/moment.min.js"></script>
<script type="text/javascript" src="/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" media="screen" />
<script type="text/javascript">
	$(function () {
	    $('#start_date').datetimepicker({
	    	'format': 'YYYY-MM-DD HH:mm:ss',
	    	'showClear': true
	    });
	    $('#end_date').datetimepicker({
	    	'format': 'YYYY-MM-DD HH:mm:ss',
	    	'showClear': true
	    });

	});
</script>