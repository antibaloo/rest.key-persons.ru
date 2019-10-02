<!doctype html>
<html lang="ru">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/app.css?ver=<?=time()?>" rel="stylesheet">
  </head>
  <body>
    <div class="parent">
      <form id ="fileForm" method="POST" enctype="multipart/form-data">
        <div class="form-group">
          <label for="images">Выберите файлы для загрузки</label>
          <input type="file" multiple class="form-control" id="images" accept="image/*">
        </div>
        <center><a id="buttonUpload" class="btn btn-primary">Загрузить</a></center>
      </form>
      <div id="resultUpload" class="central"></div>
    </div>
  </body>
  <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
  <script src="js/app.js?ver=<?=time()?>"></script>
</html>