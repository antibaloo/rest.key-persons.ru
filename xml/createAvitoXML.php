<?
/*$xml = new XMLWriter();
$xml->openURI('/home/bitrix/rest/xml/avitoTest.xml');
$xml->startDocument("1.0", "utf-8");
$xml->startElement("Ads");//Корневой элемент Ads
$xml->writeAttribute("formatVersion","3");
$xml->writeAttribute("target","Avito.ru");*/


$start = 0;
$queryUrl = 'https://moy-dom.bitrix24.ru/rest/1/2oo7egxzlw5apeao/crm.deal.list.json/';
while ($start>=0){
  $queryData = http_build_query(
    array( 
      'order' => array("ID"=>"DESC"),
      'filter' => array('TYPE_ID' => 'SALE', 'STAGE_ID' => 'PUBLISHED'),
      'start' => $start,
      'select' => array("*")
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
  
  $result = json_decode(curl_exec($curl), true);
  curl_close($curl);
  echo "<pre>";
  print_r($result);
  echo "</pre>";
  $start = ($result['next'])?$result['next']:-1;
}

/*
$xml->endElement();//Ads
$xml->endDocument();//Закрываем документ
$xml->flush();98
?>