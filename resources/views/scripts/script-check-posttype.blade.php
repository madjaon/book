<script type="text/javascript">
// choose post type
function checkPostType(id, check=1)
{
  if($('#posttype_id_'+id).is(':checked')) {
    $('#make_primary_'+id).show();
  } else {
    if($('input[name="type_main_id"]').val() == id) {
      $('input[name="type_main_id"]').val('');
    }
    $('#primary_'+id).hide();
    $('#make_primary_'+id).hide();
  }
  return;
}
function checkKey(id, key, name, check=1)
{
  $('.post-type-list').each(function(index){
    var $li = $(this);
    posttype_id = $li.find('.posttype_id');
    if(check === 1) {
      if(posttype_id.is(':checked')) {
        $li.find('.'+key).hide();
        $li.find('.make_'+key).show();
      }
    } else {
      $li.find('.'+key).hide();
      $li.find('.make_'+key).show();
    }
  });
  $('input[name="'+name+'"]').val(id);
  $('#'+key+'_'+id).show();
  $('#make_'+key+'_'+id).hide();
}
</script>
