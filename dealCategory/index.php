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
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/dealCategory/css/app.css?ver=0.0.1">
  </head>
  <body>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//api.bitrix24.com/api/v1/dev/"></script>
    <script src="/dealCategory/js/app.js?ver=<?=time()?>"></script>
  </body>
</html>