$(document).ready(function(){
  $("#agreementId").focus();
  $("#phoneNumber").mask("+7(999)999-99-99");
  $("#snils").mask("999-999-999 99");
  //$('agreementId').mask('ZZZZZZ',{translation: {'Z': {pattern: /[a-zA-Z]/, recursive: true}}});
});
$("#agreementId").keydown(function( event ) {
  var lat = /[A-Za-z]/;
  if (!lat.test(event.key)) {
    $("#resultCheck").html("<span style='color:red'>Ошибка: введен не символ латинского алфавита</span>");
    event.preventDefault();
  }else $("#resultCheck").html("&nbsp;");
});
$("#agreementId").on('keyup', function(){
  if (this.value.length == 6){
     $.ajax({
       url: "https://rest.key-persons.ru/zdz/registration/ajax.php",
       type: "POST",
       data: {
         agreementId: this.value,
         step: $("#step").val()
       },
       dataType: "text",
       success: function (data) {
         var res = data.split('|');
         if (res[0] == "OK"){
           $("#step").val("2");
           $("#leadId").val(res[1]);
           $("#agreementDiv").hide();
           $("#phoneDiv").show();
           $("#phoneNumber").focus();
         }else{
           $("#agreementId").val("");
           $("#resultCheck").html(data);         
         }
       },
       error: function (data) {
         $("#resultCheck").html("<span style='color:red;'>Фатальная ошибка: обратитесь к администратору!</span>");
       },
     });
  }
})
$("#snils").on('keyup',function( event ) {
  var snils = this.value.replace(/[^\d]/g, '');
  if (snils.length == 11){
    $.ajax({
       url: "https://rest.key-persons.ru/zdz/registration/ajax.php",
       type: "POST",
       data: {
         leadId: $("#leadId").val(),
         snils: this.value,
         phone: $("#phoneNumber").val().replace(/[^+\d]/g, ''),
         step: $("#step").val()
       },
       dataType: "text",
       success: function (data) {
         if (data == "OK"){
           $("#snilsDiv").hide();
           $("#headerDiv").hide();
           $("#resultCheck").html("<center><span style='color:green;'>Спасибо, Ваше согласие активировано!</span></center>");       
         }else{
           $("#snils").val("");
           $("#resultCheck").html(data);         
         }
       },
       error: function (data) {
         $("#resultCheck").html("<span style='color:red;'>Фатальная ошибка: братитесь к администратору!</span>");
       },
     });
  }
});
$("#phoneNumber").on('keyup',function( event ) {
  var number = this.value.replace(/[^+\d]/g, '');
  if (number.length == 12){
    $("#step").val("3");
    $("#snilsDiv").show();
    $("#phoneDiv").hide();
    $("#snils").focus();
  }
});