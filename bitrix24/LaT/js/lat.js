$(document).ready(function () {
  BX24.callMethod('user.current', {}, function(result){
    if(result.error()){
      $("#user-name").html('Ошибка запроса: ' + result.error());
    }else{
      $("#user-name").html(result.data().NAME+" "+result.data().LAST_NAME);
    }
  });
});