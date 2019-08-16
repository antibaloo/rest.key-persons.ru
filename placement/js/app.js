var $placements;
$(document).ready(function(){
  BX24.callMethod(
    'placement.list',{
    },
    function(result){
      if(result.error()) console.error(result.error());
      else{
        $.each(result.data(),function(index, value){
          console.log('Индекс: '+index+'; значение '+value);
        });
        console.info(result.data());
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
          console.log($placements[index].handler);
        });
        console.info(result.data());
      }
    }
  );
});
$('#placementSelector').on('change', function() {
  console.log(this.value);
    if (this.value == 'undefined') document.getElementById("placementForm").reset();
    else {
      $("#titlePlacement").val($placements[this.value].title);
      $("#handlerPlacement").val($placements[this.value].handler);
      $("#placementPlacement").val($placements[this.value].placement);
      $("#descriptionPlacement").val($placements[this.value].description);
    }
});