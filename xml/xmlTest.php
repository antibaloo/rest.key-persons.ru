<?
$Ads = simplexml_load_file('https://crm.ucre.ru/orenburg_avito.xml');
$xml = new XMLWriter();
$xml->openURI('/home/bitrix/rest/xml/avito.xml');
$xml->startDocument("1.0", "utf-8");
$xml->startElement("Ads");//Корневой элемент Ads
$xml->writeAttribute("formatVersion","3");
$xml->writeAttribute("target","Avito.ru");
foreach ($Ads->Ad as $Ad) {
  $xml->startElement("Ad");
  foreach($Ad as $key=>$value){
    if ($key =="Images"){
      $xml->startElement("Images");
      foreach ($Ad->$key->Image as $Image){
        $xml->startElement("Image");
        $xml->writeAttribute("url",$Image["url"]);
        //echo $Image["url"];
        $xml->endElement();
        //var_dump($Image);
        //echo "---<br>";
      }
//      var_dump($Ad->$key);
      //echo "+++<br>";
      $xml->endElement();
    }else $xml-> writeElement($key,$Ad->$key);
  }
  $xml->endElement();//Ad
}
$xml->endElement();//Ads
$xml->endDocument();//Закрываем документ
$xml->flush();
?>