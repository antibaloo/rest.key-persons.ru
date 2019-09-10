<?
$Ads = simplexml_load_file('https://crm.ucre.ru/orenburg_avito.xml');
$xml = new XMLWriter();
$xml->openURI('/home/bitrix/rest/xml/avito.xml');
$xml->startDocument("1.0", "utf-8");
$xml->startElement("Ads");//Корневой элемент Ads
$xml->writeAttribute("formatVersion","3");
$xml->writeAttribute("target","Avito.ru");
$xml->endElement();//Ads
$xml->endDocument();//Закрываем документ
$xml->flush();
?>