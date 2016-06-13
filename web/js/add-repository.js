function getReion(parentId,tag){
  $.ajax({
    url: "?r=site/getregion",
    type: 'POST',
    dataType: 'json',
    data: {
      parentId: parentId
    },
    success: function(data, status) {
      $(tag).html("");
      $.each(data, function(index, address) {
        $(tag).append("<option value=" + address['id'] + ">" + address['name'] + "</option>");
      });
    }
  });
}
$(function() {
  getReion($("#addrepository-regionprovince").val(),"#addrepository-regioncity");
  $("#addrepository-regionprovince").bind('change', function() {
    getReion($(this).val(),"#addrepository-regioncity");
  });
  $("#addrepository-regioncity").bind('change',function (){
    getReion($(this).val(),"#addrepository-regioncountry");
  });
});
