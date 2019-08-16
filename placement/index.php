<?php
if (!substr_count($_REQUEST['DOMAIN'],'.bitrix24.ru')) die("ПНХ!");
$queryUrl = 'https://'.$_REQUEST['DOMAIN'].'/rest/user.current.json';

// as user.current does not have any specific parameters we just set an access_token ("auth")
$queryData = http_build_query(array(
  "auth" => $_REQUEST['AUTH_ID']
));
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_POST => 1,
  CURLOPT_HEADER => 0,
  CURLOPT_RETURNTRANSFER => 1,
  CURLOPT_URL => $queryUrl,
  CURLOPT_POSTFIELDS => $queryData,
));

$user = json_decode(curl_exec($curl), true);
curl_close($curl);
?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/placement/css/app.css?ver=0.0.1">
  </head>
  <body>
<?switch ($_REQUEST['PLACEMENT']){
  case 'DEFAULT':?>
    <div id="app" class="container-fluid">
      <div class="bs-callout bs-callout-info">
        <p>Текущий пользователь: <span id="user-name"><?=$user['result']['NAME'].' '.$user['result']['LAST_NAME'];?></span></p>
        <form id="placementForm">
          <div class="form-group">
            <select id="placementSelector" class="browser-default custom-select">
              <option value='undefined' selected>Выберите обработчик или создайте новый</option>
            </select>
          </div>
          <div class="form-group">
            <label for="titlePlacement">TITLE</label>
            <input type="text" class="form-control" id="titlePlacement" aria-describedby="titlePlacementHelp">
            <small id="titlePlacementHelp" class="form-text text-muted">Заголовок обработчика, показывается по месту встранивания</small>
          </div>
          <div class="form-group">
            <label for="placementPlacement">PLACEMENT</label>
            <input type="text" class="form-control" id="placementPlacement" aria-describedby="placementPlacementHelp" required>
            <small id="placementPlacementHelp" class="form-text text-muted">Идентификатор требуемого места встраивания</small>
          </div>
          <div class="form-group">
            <label for="handlerPlacement">HANDLER</label>
            <input type="text" class="form-control" id="handlerPlacement" aria-describedby="handlerPlacementHelp" required>
            <small id="handlerPlacementHelp" class="form-text text-muted">URL обработчика места встраивания</small>
          </div>
          <div class="form-group">
            <label for="descriptionPlacement">DESCRIPTION</label>
            <input type="text" class="form-control" id="descriptionPlacement" aria-describedby="descriptionPlacementHelp">
            <small id="descriptionPlacementHelp" class="form-text text-muted">Описание обработчика, может выводиться по месту встраивания.</small>
          </div>
          <button id="registration" class="btn btn-success">Установить</button>&nbsp;<button id="delete" class="btn btn-danger">Удалить</button>
        </form>
      </div>
    </div>
    <?break;
  default:?>
    <div id="app" class="container-fluid">      
    </div>
    <?break?>
<?}?>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//api.bitrix24.com/api/v1/dev/"></script>
    <script src="/placement/js/app.js?ver=0.0.18"></script>
  </body>
</html>