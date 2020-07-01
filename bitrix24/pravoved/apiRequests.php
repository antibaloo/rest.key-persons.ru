<?
require($_SERVER['DOCUMENT_ROOT'].'/vendor/autoload.php');
switch($_POST['action']){    
  case "authorization":
    $pravovedClient = new PravovedApi\PravovedApiClient();
    $pravovedClient->setEmail($_POST['email']); 
    $pravovedClient->setPassword($_POST['password']);
    try {
      $token = $pravovedClient->getAuthToken();
      echo json_encode(array('status' => 'success', 'token' => $token));
    } catch (\Exception $e) {
      echo json_encode(array('status' => 'error', 'message' =>$e->getMessage()),JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    }
    break;
  case 'preorders':
    $pravovedClient = new PravovedApi\PravovedApiClient($_POST['token']);
    try {
      $preorders = $pravovedClient->getPreorders();
      // получение только активных предзаказов
      $activePreorders = $pravovedClient->filterActivePreorders($preorders);
      echo json_encode(array('status' => 'success', 'preorders' => $activePreorders));
    } catch (\Exception $e) {
      echo json_encode(array('status' => 'error', 'message' =>$e->getMessage()),JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    }
    break;
  case 'leads':
    $pravovedClient = new PravovedApi\PravovedApiClient($_POST['token']);
    //Тест юнит перебора сегодняшних лидов
    $count = $_POST['leadsCount'];
    $limit = ($count < 50)? $count: 50;
    $offset = 0;
    $leads = array();
    //$debug = array();
    try{
      do{
        if ($count < $limit) $limit = $count;
        $leadsFromPravoved = $pravovedClient->getPreorderLeads($_POST['preorderId'], $limit, $offset);
        //$debug[] = "request?limit=".$limit."&offset=".$offset;
        $leads = array_merge($leads, $leadsFromPravoved);
        sleep(60 / PravovedApi\PravovedApiClient::MAX_FREQUENCY);
        $count-=$limit;
        $offset+=$limit;
      }while ($count>0);
      echo json_encode(array('status' => 'success', 'leads' => $leads));
    }catch (\Exception $e){
      echo json_encode(array('status' => 'error', 'message' =>$e->getMessage()),JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    }
    break;
  default:
    echo json_encode(array('status' => 'error', 'message' =>'Нет такой команды: '.$_POST['action'].'!'),JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    break;
}
?>