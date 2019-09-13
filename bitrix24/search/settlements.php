<?
$queryUrl = 'https://rosreestr.ru/api/online/regions/'.$_POST['regionId'];
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_HEADER => 0,
  CURLOPT_RETURNTRANSFER => 1,
  CURLOPT_URL => $queryUrl,
));
$settlementList = curl_exec($curl);
curl_close($curl);
print_r($settlementList);
?>