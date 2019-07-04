$(function () {
  $("input[name=rating]").change(function(event) {
    var id = document.getElementById('id').value;
    if(!id) {return false;}
    var cookieName = 'rating' + id;
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax(
    {
      type: 'post',
      url: '/rating',
      data: {
        'id': id,
        'rating': document.ratingfrm.rating.value
      },
      beforeSend: function() {
        radDisable();
      },
      success: function(data)
      {
        radDisable();
        if(data) {
          document.getElementById('ratingValue').innerHTML = data.ratingValue;
          document.getElementById('ratingCount').innerHTML = data.ratingCount;
        }
        setCookie(cookieName, 1, 3650);
        return false;
      },
      error: function(xhr)
      {
        radDisable();
        return false;
      }
    });
  });
})
function radDisable() {
  var radios = document.ratingfrm.rating;
  for (var i=0, iLen=radios.length; i<iLen; i++) {
    radios[i].disabled = true;
  } 
}
function setCookie(cname,cvalue,exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires=" + d.toGMTString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
