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
if ($user['result']['ID']<>1) die("У вас нет прав для работы с приложением!!!");
?>
<!doctype html>
<html lang="ru">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/search.css?ver=<?=time()?>" rel="stylesheet">
  </head>
  <body>
    <div class="parent">
      <div class="central">
        <select id="blockSelector" class="browser-default custom-select">
          <option selected>выберите субъект РФ</option>
          <?foreach ($repoList['result'] as $repo){?>
          <option value="<?=$repo['ID']?>"><?=$repo['NAME']?></option>
          <?}?>
        </select>
      </div>
      <div class="left">
      </div>
      <div class="right">
      </div>
    </div>
  </body>
  <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
  <script src="js/search.js?ver=<?=time()?>"></script>
</html>