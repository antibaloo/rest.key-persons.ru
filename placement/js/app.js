var $placements;
$(document).ready(function(){
  BX24.callMethod(
    'placement.list',{
    },
    function(result){
      if(result.error()) console.error(result.error());
      else{
        $.each(result.data(),function(index, value){
          $("#placementPlacement").append('<option value='+value+'>'+value+'</option>');
        });
      }
    }
  );
  BX24.callMethod(
    'placement.get',{
    },
    function(result){
      if(result.error()) console.error(result.error());
      else {
        $placements = result.data();
        $.each($placements,function(index, value){
          $("#placementSelector").append('<option value='+index+'>'+value.title+'</option>');
        });
      }
    }
  );
});
$('#placementSelector').on('change', function() {
  if (this.value == 'undefined') document.getElementById("placementForm").reset();
  else {
    $("#titlePlacement").val($placements[this.value].title);
    $("#handlerPlacement").val($placements[this.value].handler);
    $("#placementPlacement option[value=" + $placements[this.value].placement + "]").attr('selected', 'true');
    //$("#placementPlacement").val($placements[this.value].placement);
    $("#descriptionPlacement").val($placements[this.value].description);
  }
});
$('.btn').on('click', function (){
  event.preventDefault();
  switch ($(this).attr("id")){
    case "registration":
      BX24.callMethod(
        'placement.bind',{
         "PLACEMENT" : $("#placementPlacement").val(),
          "HANDLER" : $("#handlerPlacement").val(),
          "TITLE" : $("#titlePlacement").val(),
          "DESCRIPTION" : $("#descriptionPlacement").val(),
          "GROUP_NAME" : $("#groupPlacement").val()
        },
        function(result){
          if(result.error()) {
            console.log(result.error());
          }else{
            location.reload();
            //document.getElementById("blockForm").reset();
            console.info(result.data());
            //$('#blockSelector').append($("<option></option>").attr("value",result.data()).text(nameBlockTemp));
          }
        }
      );
      break;
    case "delete":
      BX24.callMethod(
        'placement.unbind',{
         "PLACEMENT" : $("#placementPlacement").val(),
          "HANDLER" : $("#handlerPlacement").val(),
        },
        function(result){
          if(result.error()) {
            console.log(result.error());
          }else{
            location.reload();
            console.info(result.data());
          }
        }
      );
      break;
  }
});