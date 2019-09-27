function $_GET(key) {
  var s = window.location.search;
  s = s.match(new RegExp(key + '=([^&=]+)'));
  return s ? s[1] : false;
}
$(document).ready(function(){
  var agreementId = $_GET('agreementId');
  var dealId = $_GET('dealId');
  if (agreementId !=false || dealId!=false){
    $.ajax({
      url: "https://rest.key-persons.ru/zdz/results/ajax.php",
      type: "POST",
      data: {
        agreementId: agreementId,
        dealId: dealId
      },
      dataType: "text",
      success: function (data) {
        if (data !='error'){
          $("#results").html(data);
        }else{
          $("#results").html("<center><h1 style='color:red;'>СТРАНИЦА НЕ НАЙДЕНА</h1></center");
          $(".myBackGround").css("height", "100vh")
        }
      },
      error: function (data) {
        $("#results").html("<center><h1 style='color:red;'>Фатальная ошибка: обратитесь к администратору!</h1></center");
        $(".myBackGround").css("height", "100vh")
      },
    });
  }else{
    $("#results").html("<center><h1 style='color:red;'>СТРАНИЦА НЕ НАЙДЕНА</h1></center");
    $(".myBackGround").css("height", "100vh")
  }
});