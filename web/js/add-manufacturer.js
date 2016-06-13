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
  getReion($("#addmanufacturerform-regionprovince").val(),"#addmanufacturerform-regioncity");
  $("#addmanufacturerform-regionprovince").bind('change', function() {
    getReion($(this).val(),"#addmanufacturerform-regioncity");
  });
  $("#addmanufacturerform-regioncity").bind('change',function (){
    getReion($(this).val(),"#addmanufacturerform-regioncountry");
  });
});
