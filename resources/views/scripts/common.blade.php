<script type="text/javascript">
$(document).ready(function(){
  checkInputNumber();
  toggleBtnSelected();
});
function checkInputNumber()
{
  $('.onlyNumber').keypress(function(e) {
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
      return false;
    }
  });
}
function toggle(source) {
  checkboxes = document.getElementsByName('id[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
function toggleBtnSelected() {
  $("input:checkbox").click(function(){
    // check to show/hide button
    var selected = new Array();
    $("input:checkbox[class=id]:checked").each(function(){
        selected.push($(this).val());
    });
    if(selected.length > 0) {
      $(".btnSelected").show();
    } else {
      $(".btnSelected").hide();
    }
  });
}
</script>
