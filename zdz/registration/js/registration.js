/*var f = $('#block5252');
$(window).scroll(function() {
  if (navigator.platform.indexOf("iPhone") !== -1){
    var w = $(this);
    if (w.scrollTop() > (f.offset().top - w.height())) location.href = 'https://rest.key-persons.ru/zdz/registration/block.html';
  }
});*/
$(document).ready(function(){
  //$("#firstCode").focus();
  //$("#width").html("Ширина "+$(window).width());
  //$("#height").html("Высота "+$(window).height());
 //$("#resultCheck").html(navigator.platform);
});
$("#reload").on('click',function(){
  location.reload();
});
$("#lastCode").on('keyup',function(){
  var code="";
  if ($(this).val().length>0){
    $(".code").each(function(){
      code+=$(this).val();
    });
    $.ajax({
      url: "https://rest.key-persons.ru/zdz/registration/ajax.php",
      type: "POST",
      data: {
        agreementId: code,
        step: $("#step").val()
      },
      dataType: "text",
      success: function (data) {
        var res = data.split('|');
        if (res[0] == "OK"){
          $("#step").val("2");
          $("#leadId").val(res[1]);
          
          $("#agreementId").val(code);
          $("#agreementH2").hide();
          $("#agreementDiv").hide();
          $("#phoneH2").show();
          $("#phoneDiv").show();
          $("#firstPhone").focus();
          $("#resultCheck").html("");
        }else{
          $(".code").each(function(){
            $(this).val("");
          });
          $("#resultCheck").html(data);
          $("#firstCode").focus();
        }
      },
      error: function (data) {
        $("#resultCheck").html("<span style='color:red;'>Фатальная ошибка: обратитесь к администратору!</span>");
      },
    });
  }
});
$("#lastPhone").on('keyup',function(){
  var phone="";
  if ($(this).val().length>0){
    $(".phone").each(function(){
      phone+=$(this).val();
    });
    $("#step").val("3");
    $("#phoneNumber").val(phone);
    $("#phoneH2").hide();
    $("#phoneDiv").hide();
    $("#snilsH2").show();
    $("#snilsDiv").show();        
    $("#firstSnils").focus();
  }
});
$("#lastSnils").on('keyup',function(){
  $('#lastSnils').attr('readonly', true);
  var snils="";
  if ($(this).val().length>0){
    $(".snils").each(function(){
      snils+=$(this).val();
    });
    
    $.ajax({
      url: "https://rest.key-persons.ru/zdz/registration/ajax.php",
      type: "POST",
      data: {
        leadId: $("#leadId").val(),
        snils: snils,
        phone: "+7"+$("#phoneNumber").val(),
        step: $("#step").val()
      },
      dataType: "text",
      success: function (data) {
        if (data == "OK"){
          $("#snilsDiv").hide();
          $("#snilsH2").hide();
          $("#success").show();
          $("#reload").show(); 
        }else{
          $(".snils").each(function(){
            $(this).val("");
          });
          $("#resultCheck").html(data);         
        }
      },
      error: function (data) {
        $("#resultCheck").html("<span style='color:red;'>Фатальная ошибка: братитесь к администратору!</span>");
      },
    });
  }else{
    $('#lastSnils').attr('readonly', false);
  }
  
});    
function processInputDigits(holder){
  var elements = holder.children(), //taking the "kids" of the parent
      str = ""; //unnecesary || added for some future mods
  
  elements.each(function(e){ //iterates through each element
    var val = $(this).val().replace(/\D/,""), //taking the value and parsing it. Returns string without changing the value.
        focused = $(this).is(":focus"), //checks if the current element in the iteration is focused
        parseGate = false;
    val.length==1?parseGate=false:parseGate=true; 
    /*a fix that doesn't allow the cursor to jump 
    to another field even if input was parsed 
    and nothing was added to the input*/
    
    $(this).val(val); //applying parsed value.
    
    var	exist;
    if(parseGate&&val.length>1){ //Takes you to another input
      exist = elements[e+1]?true:false; //checks if there is input ahead
      exist&&val[1]?( //if so then
        elements[e+1].disabled=false,
        elements[e+1].value=val[1], //sends the last character to the next input
        elements[e].value=val[0], //clears the last character of this input
        elements[e+1].focus() //sends the focus to the next input
      ):void 0;
    } else if(parseGate&&focused&&val.length==0){ //if the input was REMOVING the character, then
      exist = elements[e-1]?true:false; //checks if there is an input before
      if(exist) elements[e-1].focus(); //sends the focus back to the previous input
    }
    
    val==""?str+=" ":str+=val;
  });
}    
function processInputLetters(holder){
  var elements = holder.children(), //taking the "kids" of the parent
      str = ""; //unnecesary || added for some future mods
  
  elements.each(function(e){ //iterates through each element
    var val = $(this).val().replace(/[^A-Za-z]/,""), //taking the value and parsing it. Returns string without changing the value.
        focused = $(this).is(":focus"), //checks if the current element in the iteration is focused
        parseGate = false;
    val.length==1?parseGate=false:parseGate=true; 
    /*a fix that doesn't allow the cursor to jump 
    to another field even if input was parsed 
    and nothing was added to the input*/
    
    $(this).val(val); //applying parsed value.
    
    if(parseGate&&val.length>1){ //Takes you to another input
      var	exist = elements[e+1]?true:false; //checks if there is input ahead
      exist&&val[1]?( //if so then
        elements[e+1].disabled=false,
        elements[e+1].value=val[1], //sends the last character to the next input
        elements[e].value=val[0], //clears the last character of this input
        elements[e+1].focus() //sends the focus to the next input
      ):void 0;
    } else if(parseGate&&focused&&val.length==0){ //if the input was REMOVING the character, then
      var exist = elements[e-1]?true:false; //checks if there is an input before
      if(exist) elements[e-1].focus(); //sends the focus back to the previous input
    }
    
    val==""?str+=" ":str+=val;
  });
}

$("#agreementDiv").on('input', function(){processInputLetters($(this))}); //still wonder how it worked out. But we are adding input listener to the parent... (omg, jquery is so smart...);
$("#phoneDiv").on('input', function(){processInputDigits($(this))}); //still wonder how it worked out. But we are adding input listener to the parent... (omg, jquery is so smart...);
$("#snilsDiv").on('input', function(){processInputDigits($(this))}); //still wonder how it worked out. But we are adding input listener to the parent... (omg, jquery is so smart...);
$(".inputs").on('click', function(e) { //making so that if human focuses on the wrong input (not first) it will move the focus to a first empty one.
  var els = $(this).children(),
      str = "";
  els.each(function(e){
    var focus = $(this).is(":focus");
    $this = $(this);
    while($this.prev().val()==""){
      $this.prev().focus();
      $this = $this.prev();
    }
  })
});