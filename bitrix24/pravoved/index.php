<?
require($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');
$pravoved = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT']."/../pravoved_params"));
$pravovedClient = new PravovedApi\PravovedApiClient();

$email="iviv11111@mail1.ru";
$password="KNA31051958_";
$pravovedClient->setEmail($pravoved->email); 
$pravovedClient->setPassword($pravoved->password);

try{
  $token = $pravovedClient->getAuthToken();
  echo "token: ".$token;
}catch (\Exception $e){
  echo $e->getMessage();
  /*echo "<pre>";
  print_r($e);// обработка неудачной аутентификации
  echo "</pre>";*/
}

/*
$pravovedClient = new PravovedApi\PravovedApiClient($token);
try {
    $preorders = $pravovedClient->getPreorders();
} catch (\Exception $e) {
    // обработка ошибки получения предзаказов
  print_r($e);
  echo "Ошибка получения предзаказов";
}
// задержка между запросами для обхода ограничения на частоту запросов
sleep(60 / PravovedApi\PravovedApiClient::MAX_FREQUENCY);

// получение только активных предзаказов
$activePreorders = $pravovedClient->filterActivePreorders($preorders);
echo "<pre>";print_r($activePreorders);echo "</pre>";

foreach ($activePreorders as $activePreorder) {

    $preorderId = $activePreorder['id'];

    try {
        sleep(60 / PravovedApi\PravovedApiClient::MAX_FREQUENCY);
        // Получим 50 последних лидов предзаказа
        $leadsFromPravoved = $pravovedClient->getPreorderLeads($preorderId, 50);
      echo "<pre>";print_r($leadsFromPravoved);echo "</pre>";
    } catch (\Exception $e) {
        echo "Ошибка получения лидов";
    }
}
*/
?>