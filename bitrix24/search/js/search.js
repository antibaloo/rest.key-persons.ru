$('#regionId').on('change', function() {
  $('#settlementId').find('option').remove();
  if (this.value != ""){
    $.ajax({
      url: "settlements.php",
      type: "POST",
      data: {
        regionId: this.value
      },
      dataType: "text",
      success: function (data) {
        var result = jQuery.parseJSON( data );
        $("#settlementId").append('<option value="" selected>выберите населенный пункт</option>');
        $.each(result,function(index, value){
          $("#settlementId").append('<option value='+value.id+'>'+value.name+'</option>');
        });
      },
      error: function (data) {
        $("#resultSearch").html("<span style='color:red;'>Ошибка при чтении списка населенных пунктов!<br>Обратитесь к администратору!</span>");
      },
    });
    $('#settlementId').prop('disabled', false);
  }else{
    $('#settlementId').prop('disabled', true);
  }
});
$('#macroRegionId').on('change', function() {
  $('#regionId').find('option').remove();
  $('#settlementId').find('option').remove();
  if (this.value != ""){
    $.ajax({
      url: "regions.php",
      type: "POST",
      data: {
        macroRegionId: this.value
      },
      dataType: "text",
      success: function (data) {
        var result = jQuery.parseJSON( data );
        $("#regionId").append('<option value="" selected>выберите район субъекта/город</option>');
        $.each(result,function(index, value){
          $("#regionId").append('<option value='+value.id+'>'+value.name+'</option>');
        });
      },
      error: function (data) {
        $("#resultSearch").html("<span style='color:red;'>Ошибка при чтении списка подчиненных регионов!<br>Обратитесь к администратору!</span>");
      },
    });
    $('#regionId').prop('disabled', false);
  } else {
    $('#regionId').prop('disabled', true);
    $('#settlementId').prop('disabled', true);
  }
});
$("#buttonSearch").click(function(){
  $("#resultSearch").html('<center><i class="fa fa-spinner fa-spin"></i></center>');
  $.ajax({
    url: "search.php",
    type: "POST",
    data: {
      macroRegionId: $("#macroRegionId").val(),
      regionId: $("#regionId").val(),
      settlementId: $("#settlementId").val(),
      street: $("#street").val(),
      house: $("#house").val(),
      apartment: $("#apartment").val()
    },
    dataType: "text",
    success: function (data) {
      $("#resultSearch").html(data);
    },
    error: function (data) {
      $("#resultSearch").html("<span style='color:red;'>Ошибка!<br>Обратитесь к администратору!</span>");
    },
  });
});