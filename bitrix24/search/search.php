<?
if ($_POST['macroRegionId'] == "выберите субъект РФ") die("<span style='color:red;'>Ошибка: не введен субъект РФ!</span>");
if ($_POST['regionId'] == "") die("<span style='color:red;'>Ошибка: не введен район субъекта или город!</span>");
if ($_POST['street'] == "") die("<span style='color:red;'>Ошибка: не введена улица!</span>");
if ($_POST['house'] == "") die("<span style='color:red;'>Ошибка: не введен дом!</span>");
$curl = curl_init();
$data = array();
if ($_POST['macroRegionId'])  $data['macroRegionId'] = $_POST['macroRegionId'];
if ($_POST['regionId'])  $data['RegionId'] = $_POST['regionId'];
if ($_POST['settlementId'])  $data['settlementId'] = $_POST['settlementId'];
if ($_POST['street'])  $data['street'] = $_POST['street'];
if ($_POST['house']) $data['house'] = $_POST['house'];
if ($_POST['apartment'])  $data['apartment'] = $_POST['apartment'];
$queryUrl = 'https://rosreestr.ru/api/online/address/fir_objects?'.http_build_query($data);


curl_setopt_array($curl, array(
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_HEADER => 0,
  CURLOPT_RETURNTRANSFER => 1,
  CURLOPT_URL => $queryUrl,
));
$objectList = json_decode(curl_exec($curl), true);
curl_close($curl);
$objects = array();
foreach ($objectList as $key=>$value){
  if ($value['srcObject'] == 1){
    unset($objectList[$key]);
    continue;
  }
  $curl = curl_init();
  $queryUrl = 'https://rosreestr.ru/api/online/fir_object/'.$value['objectId'];
  curl_setopt_array($curl, array(
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_HEADER => 0,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $queryUrl,
  ));
  $object = json_decode(curl_exec($curl), true);
  curl_close($curl);
  $objects[$key]= $object;
}

echo "<pre>";
print_r($objects);
echo "</pre>";
echo $queryUrl;
?>