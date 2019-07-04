<!-- Select2 -->
<link rel="stylesheet" href="/plugins/select2/dist/css/select2.min.css">
<script src="/plugins/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  //Initialize Select2 Elements
  $(".select2").select2({tags: "true", placeholder: "Select an option", allowClear: true});
  //Initialize Select2 Elements with limit
  $(".select2limit").select2({tags: "true", placeholder: "Select an option", allowClear: true, maximumSelectionLength: 1});
});
</script>
