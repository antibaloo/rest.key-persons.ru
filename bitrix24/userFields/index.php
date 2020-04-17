<!doctype html>
<html lang="ru">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/userType.css?ver=<?=time()?>" rel="stylesheet">
  </head>
  <body>
    <div class="parent">
      <div class="left">
        <h5>Список пользовательских полей в лидах:</h5>
        <div id="leadUserFields">
          <ul id="leadUserFieldsList"></ul>
          <div class="form-group">
            <label for="leadFieldId">ID поля</label>
            <input type="text" id="leadFieldId" class="form-control" readonly>
          </div>
          <div class="form-group">
            <label for="leadFieldName">Имя поля (латиница)</label>
            <input type="text" id="leadFieldName" class="form-control latinOnly">
          </div>
          <div class="form-group">
            <label for="leadFieldLabel">Метка поля для форм и списков</label>
            <input type="text" id="leadFieldLabel" class="form-control russianOnly">
          </div>        
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="leadFieldMandatory" value="Y">
            <label class="form-check-label" for="leadFieldMandatory">Обязательное поле</label>
          </div>
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="leadFieldMultiple" value="Y">
            <label class="form-check-label" for="leadFieldMultiple">Множественное поле</label>
          </div>
          <div class="form-group">
            <label for="leadFieldType">Тип поля</label>
            <select id="leadFieldType" class="browser-default custom-select"></select>
          </div>
        </div>
        <center><a id="addLeadUserField" class="btn btn-primary">Добавить</a>&nbsp;<a id="clearLeadUserField" class="btn btn-warning">Отмена</a>&nbsp;<a id="deleteLeadUserField" class="btn btn-danger disabled">Удалить</a></center>
      </div>
      <div class="right">
        <h5>Список пользовательских полей в сделках:</h5>
        <div id="dealUserFields">
          <ul id="dealUserFieldsList"></ul>
          <div class="form-group">
            <label for="dealFieldId">ID поля</label>
            <input type="text" id="dealFieldId" class="form-control" readonly>
          </div>
          <div class="form-group">
            <label for="dealFieldName">Имя поля (латиница)</label>
            <input type="text" id="dealFieldName" class="form-control latinOnly">
          </div>
          <div class="form-group">
            <label for="dealFieldLabel">Метка поля для форм и списков</label>
            <input type="text" id="dealFieldLabel" class="form-control russianOnly">
          </div>        
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="dealFieldMandatory" value="Y">
            <label class="form-check-label" for="dealFieldMandatory">Обязательное поле</label>
          </div>
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="dealFieldMultiple" value="Y">
            <label class="form-check-label" for="dealFieldMultiple">Множественное поле</label>
          </div>
          <div class="form-group">
            <label for="dealFieldType">Тип поля</label>
            <select id="dealFieldType" class="browser-default custom-select"></select>
          </div>
        </div>
        <center><a id="addDealUserField" class="btn btn-primary">Добавить</a>&nbsp;<a id="clearDealUserField" class="btn btn-warning">Отмена</a>&nbsp;<a id="deleteDealUserField" class="btn btn-danger disabled">Удалить</a></center>
      </div>
      <div class="central">
        <h5>Список пользовательских типов полей:</h5>
        <div id="userTypesHandlers">
          <ul id="userTypesList"></ul>
          <div class="form-group">
            <label for="userTypeId">Строковый код типа</label>
            <input type="text" id="userTypeId" class="form-control latinOnly">
          </div>
           <div class="form-group">
            <label for="handler">Адрес обработчика</label>
            <input type="text" id="handler" class="form-control latinOnly">
          </div>
          <div class="form-group">
            <label for="title">Текстовое название типа</label>
            <input type="text" id="title" class="form-control">
          </div>
          <div class="form-group">
            <label for="description">Текстовое описание типа</label>
            <input type="text" id="description" class="form-control">
          </div>
        </div>
        <center><a id="addUserType" class="btn btn-primary">Добавить</a>&nbsp;<a id="clearUserType" class="btn btn-warning">Отмена</a>&nbsp;<a id="deleteUserType" class="btn btn-danger disabled">Удалить</a></center>
      </div>
      <div id="messages" class="central"></div>
    </div>
  </body>
  <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
  <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="//api.bitrix24.com/api/v1/"></script>
  <script src="js/userType.js?ver=<?=time()?>"></script>
</html>