
$(document).ready(function () {
  $('#selectDivs').change(function () {
    var selectedDiv = $(this).val();
    $('.hidden').hide();
    $('#' + selectedDiv).show();
  });
});



