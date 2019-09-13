<?php
if (!substr_count($_REQUEST['DOMAIN'],'.bitrix24.ru')) die("ПНХ!");

$queryUrl = 'https://rosreestr.ru/api/online/macro_regions';
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_HEADER => 0,
  CURLOPT_RETURNTRANSFER => 1,
  CURLOPT_URL => $queryUrl,
));

$macroRegionList = json_decode(curl_exec($curl), true);
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
    <link href="css/search.css?ver=<?=time()?>" rel="stylesheet">
  </head>
  <body>
    <div class="parent">
      <form>
        <div class="left">
          <div class="form-group">
            <label for="macroRegionId">Субъект РФ</label>
            <select id="macroRegionId" class="browser-default custom-select">
              <option value="" selected>выберите субъект РФ</option>
              <?foreach ($macroRegionList as $macroRegion){?>
              <option value="<?=$macroRegion['id']?>"><?=$macroRegion['name']?></option>
              <?}?>
            </select>
          </div>
          <div class="form-group">
            <label for="regionId">Район субъекта РФ/Город</label>
            <select id="regionId" class="browser-default custom-select" disabled>
            </select>
          </div>
          <div class="form-group">
            <label for="settlementId">Населенный пункт</label>
            <select id="settlementId" class="browser-default custom-select" disabled>
            </select>
          </div>
        </div>
        <div class="right">
          <div class="form-group">
            <label for="street">Улица</label>
            <input type="text" class="form-control" id="street">
          </div>
          <div class="form-group">
            <label for="house">Дом</label>
            <input type="text" class="form-control" id="house">
          </div>
          <div class="form-group">
            <label for="apartment">Квартира</label>
            <input type="text" class="form-control" id="apartment">
          </div>
        </div>
        <center><a id="buttonSearch" class="btn btn-primary">Искать</a></center>
      </form>
      <div id="resultSearch" class="central">
      </div>
    </div>
  </body>
  <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
  <script src="js/search.js?ver=<?=time()?>"></script>
</html>