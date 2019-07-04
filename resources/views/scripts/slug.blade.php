<script type="text/javascript">
function stringToSlug(str) {
  str = str.replace(/^\s+|\s+$/g, ''); // trim
  str = str.toLowerCase();
  // remove accents, swap ñ for n, etc
  var from = "àáạảãâầấậẩẫăằắặẳẵäèéẹẻẽêềếệểễëìíịỉĩòóọỏõôồốộổỗơờớợởỡöùúụủũưừứựửữüûỳýỵỷỹđñç·/_,:;";
  var to   = "aaaaaaaaaaaaaaaaaaeeeeeeeeeeeeiiiiioooooooooooooooooouuuuuuuuuuuuuyyyyydnc------";
  for (var i=0, l=from.length ; i<l ; i++) {
    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
  }
  str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
    .replace(/\s+/g, '-') // collapse whitespace and replace by -
    .replace(/-+/g, '-'); // collapse dashes
  return str;
}
function convertToSlug(val)
{
    var slug = stringToSlug(val);
    $('input[name=slug]').val(slug);
}
</script>
