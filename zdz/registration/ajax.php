<?
if ($_POST["step"] == "1"){
  $queryUrl = 'https://zdz-online.bitrix24.ru/rest/16/opxrg0lm0un683us/crm.lead.list.json/';
  $queryData = http_build_query(
    array( 
      'order' => array("ID"=>"DESC"),
      'filter' => array("UF_CRM_1522138105"=>$_POST['agreementId']),
      'select' => array("ID","TITLE","STATUS_ID")
    )
  );
  
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_POST => 1,
    CURLOPT_HEADER => 0,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $queryUrl,
    CURLOPT_POSTFIELDS => $queryData,
  ));
  
  $replay = json_decode(curl_exec($curl), true);
  curl_close($curl);
  if ($replay['total'] >1) die("<span style='color:red;'>Несколько согласий в системе. Обратитесь к администратору.</span>");
  if ($replay['total'] == 0)  die("<span style='color:red;'>Проверьте правильность ввода кода активации согласия.</span>");
  if ($replay['result'][0]['STATUS_ID'] != "NEW" && $replay['result'][0]['STATUS_ID'] != "1") die("<span style='color:red;'>Согласие с введённым кодом уже активировано.</span>");
  echo "OK|".$replay['result'][0]['ID'];
}
if ($_POST["step"] == "3"){
  $queryUrl = 'https://zdz-online.bitrix24.ru/rest/16/opxrg0lm0un683us/crm.lead.update.json/';
  $queryData = http_build_query(
    array( 
      'id' => $_POST['leadId'],
      'fields' => array( 
        'STATUS_ID' => "IN_PROCESS",
        'PHONE' => array(array("VALUE" => $_POST['phone'], "VALUE_TYPE" => "OTHER")),
        'UF_CRM_1522222202' => $_POST['snils']
      ), 
      'params' => array("REGISTER_SONET_EVENT" => "Y") )
  );
  
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_SSL_VERIFYPEER => 0,
    CURLOPT_POST => 1,
    CURLOPT_HEADER => 0,
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => $queryUrl,
    CURLOPT_POSTFIELDS => $queryData,
  ));
  
  $replay = json_decode(curl_exec($curl), true);
  curl_close($curl);
  if ($replay['result'] == 1) echo "OK";
  else echo "<span style='color:red;'>Ошибка!<br> Согласие не зарегистрировано. Обратитесь к администратору.</span>";
}
?>