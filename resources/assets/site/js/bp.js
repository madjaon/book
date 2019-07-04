function paging(page) {
  var id = document.getElementById('id').value;
  $.ajax(
  {
    type: 'post',
    url: '/paging',
    data: {
      'id': id,
      'page': page
    },
    // beforeSend: function() {
    //   $('#chapters button').html('...');
    // },
    success: function(data)
    {
      $('#chapters').html(data);
      return false;
    },
    error: function(xhr)
    {
      $('#chapters').html('');
      return false;
    }
  });
}
