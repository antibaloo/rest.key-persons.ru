<?php
if (!substr_count($_REQUEST['DOMAIN'],'.bitrix24.ru')) die("ПНХ!");
$placementOptions = isset($_REQUEST['PLACEMENT_OPTIONS']) ? json_decode($_REQUEST['PLACEMENT_OPTIONS'], true) : array();
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
<!doctype html>
<html lang="ru">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/lat.css?ver=<?=time()?>" rel="stylesheet">
  </head>
  <body>
    <div id="app" class="container-fluid">
      <div class="bs-callout bs-callout-info">
        <h4>Обучение и тестирование в АН "Ключевые персоны"</h4>
        <p>Текущий пользователь: <span id="user-name"><?=$user['result']['NAME'].' '.$user['result']['LAST_NAME'];?></span></p>
      </div>
    </div>
  </body>
  <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
  <script src="js/lat.js?ver=<?=time()?>"></script>
</html>