var files; // переменная. будет содержать данные файлов
// заполняем переменную данными, при изменении значения поля file 
$('#images').on('change', function(){
	files = this.files;
});
$("#buttonUpload").on('click',function(event){
  $("#resultUpload").html('<center><i class="fa fa-spinner fa-spin"></i></center>');
  event.stopPropagation(); // остановка всех текущих JS событий
	event.preventDefault();
  // ничего не делаем если files пустой
	if( typeof files == 'undefined' ){
    $("#resultUpload").html('Не выбраны файлы для загрузки.');
    return;
  }
 /* if (files.length > 5){
    $("#resultUpload").html('Можно передать не более 5 файлов за сеанс!');
    return;
  }*/
	// создадим объект данных формы
	var data = new FormData();
	// заполняем объект данных файлами в подходящем для отправки формате
	$.each( files, function( key, value ){
		data.append( key, value );
	});
	// добавим переменную для идентификации запроса
	data.append( 'my_file_upload',1);
  // AJAX запрос
  $.ajax({
    url         : 'ajax.php',
    type        : 'POST', // важно!
    data        : data,
    cache       : false,
    dataType    : 'json',
    // отключаем обработку передаваемых данных, пусть передаются как есть
    processData : false,
    // отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
    contentType : false, 
    // функция успешного ответа сервера
    success     : function(respond, status, jqXHR){
      $('#fileForm')[0].reset();
      // ОК - файлы загружены
      if( typeof respond.error === 'undefined' ){
        // выведем пути загруженных файлов в блок '#resultUpload'
        var files_path = respond.files;
        var html = '';
        $.each(files_path, function( key, val){
          html += val +'<br>';
        } )
        console.log(respond);
        $('#resultUpload').html(html);
      }
      // ошибка
      else {
        $("#resultUpload").html('ОШИБКА: ' + respond.error);
      }
    },
    // функция ошибки ответа сервера
    error: function(jqXHR, status, errorThrown){
      console.log('ОШИБКА AJAX запроса: ' + status, jqXHR);
    }
  });
});