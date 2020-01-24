<?if($_POST['agreementId'] =="false"|| $_POST['dealId'] == "false"){
  echo "error";
}else{
  $queryUrl = 'https://zdz-online.bitrix24.ru/rest/16/opxrg0lm0un683us/crm.deal.list.json/';
  $queryData = http_build_query(
    array( 
      'order' => array("ID"=>"DESC"),
      'filter' => array("ID" => $_POST['dealId'],"UF_CRM_5ABC6DAD6F1EC"=>$_POST['agreementId']),
      'select' => array(
        "ID",
        "UF_CRM_5ABC6DAD6F1EC",   //ID согласия
        "UF_CRM_1579668211",      //счетчик просмотра результатов
        "STAGE_ID", 
        "UF_CRM_5B1B9EE8CFA0A",   //Имя ребенка
        "UF_CRM_5ABC6DADA4268",   //СНИЛС
        "ASSIGNED_BY_ID",
        "UF_CRM_5B1B9EE8E5EC2",   //Дата рождения
        "UF_CRM_5BB1B8D60CD7F",   //Школа
        "UF_CRM_1550386626",      //R OD Sph
        "UF_CRM_1550386670",      //R OD Cyl
        "UF_CRM_1549866056",      //R Visus
        "UF_CRM_1549866002",      //Диагноз R (OD)
        "UF_CRM_1552244208",      //Картинка R
        "UF_CRM_1550386686",      //L OS Sph
        "UF_CRM_1550386706",      //L OS Cyl
        "UF_CRM_1549866088",      //L Visus
        "UF_CRM_1550321518",      //Диагноз L (OS)
        "UF_CRM_1552244232",      //Картинка L
        "COMMENTS",
        "UF_CRM_1550485084",      //Result описание 1
        "UF_CRM_1550485124",      //Result описание 2
        "UF_CRM_1550760923"       //Результат работы с аппарата
      )
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
  
  $queryUrl = 'https://zdz-online.bitrix24.ru/rest/16/opxrg0lm0un683us/user.get.json/';
  $queryData = http_build_query(
    array( 
      "ID" => $replay['result'][0]['ASSIGNED_BY_ID']
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
  
  $user = json_decode(curl_exec($curl), true);
  curl_close($curl);
  
  if ($replay['total'] == 1 && $replay['result'][0]['STAGE_ID'] == "WON"){
    $counter = (integer) $replay['result'][0]['UF_CRM_1579668211'];
    $counter++;//Увеличиваем счетчик просмотров
    /*Записываем новое знчение счетчика*/
    $queryUrl = 'https://zdz-online.bitrix24.ru/rest/16/opxrg0lm0un683us/crm.deal.update.json/';
    $queryData = http_build_query(
      array( 
        'id' => $replay['result'][0]['ID'],
        'fields' => array( 
          'UF_CRM_1579668211' => $counter,
          'UF_CRM_1579668237' => date("c")
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
    
    $update = json_decode(curl_exec($curl), true);
    curl_close($curl);
    /*--------------------------------*/
?>
<div class="title-result">
  <h2>Результаты скрининга зрения вашего ребёнка</h2>
</div>
<div class="panel-info">
  <div class="block-info">
    <img width="94" alt="Зрение для Знаний" src="https://rest.key-persons.ru/zdz/results/img/dotline2.png" height="15">&nbsp;Согласие <?=$replay['result'][0]['UF_CRM_5ABC6DAD6F1EC']?>
  </div>
</div>
<div class="panel-info panel-info-block">
  <div class="row-flex">
    <div class="item-flex w50">
      <div class="block-info">
        <p>СНИЛС: <?=$replay['result'][0]['UF_CRM_5ABC6DADA4268']?></p>
        <p>Школа: <?=$replay['result'][0]['UF_CRM_5BB1B8D60CD7F']?></p>
      </div>
    </div>
    <div class="item-flex w50 pl20">
      <div class="block-info">
        <p><?=$user['result'][0]['WORK_POSITION']?></p>
      </div>
    </div>
  </div>
</div>
<div class="panel-info">
  <div class="block-info">
    <h3>Уважаемый родитель!</h3>
  </div>
  <div class="block-info">
    Сегодня Ваш ребенок прошел обследование зрения с использованием высокоточного оборудования Righton RetinoMax Plus K-3 (Япония) в рамках проведения ежегодного профилактического осмотра, с целью выявления болезней глаз на ранней стадии в течение учебного года. 
  </div>
  <div class="block-info">
    Мы получили следующие результаты скрининга Вашего ребенка: 
  </div>
</div>
<div class="panel-info panel-info-block table-block">
  <div class="block-table-result">
    <div class="row-flex">
      <div class="item-flex w50">Правый глаз</div>
      <div class="item-flex w50">Левый глаз </div>
    </div>
    <div class="row-flex">
      <div class="item-flex w50 back-gray">SPH&nbsp;<?=$replay['result'][0]['UF_CRM_1550386626']?></div>
      <div class="item-flex w50 back-gray">SPH&nbsp;<?=$replay['result'][0]['UF_CRM_1550386686']?></div>
    </div>
    <div class="row-flex">
      <div class="item-flex w50 back-gray">CYL&nbsp;<?=$replay['result'][0]['UF_CRM_1550386670']?></div>
      <div class="item-flex w50 back-gray">CYL&nbsp;<?=$replay['result'][0]['UF_CRM_1550386706']?></div>
    </div>
    <div class="row-flex">
      <div class="item-flex w100">Результаты проверочной таблицы </div>
    </div>
    <div class="row-flex">
      <div class="item-flex w50 back-gray"><?=$replay['result'][0]['UF_CRM_1549866056']?></div>
      <div class="item-flex w50 back-gray"><?=$replay['result'][0]['UF_CRM_1549866088']?></div>
    </div>
    <div class="row-flex">
      <div class="item-flex w50">
        Показания:
        <label><?=$replay['result'][0]['UF_CRM_1549866002']?></label>
        <?=($replay['result'][0]['UF_CRM_1549866002'] == "Норма")?"<img width='130' alt='Зрение для Знаний' src='https://rest.key-persons.ru/zdz/results/img/_.png'>":$replay['result'][0]['UF_CRM_1552244208']?>
      </div>
      <div class="item-flex w50">
        Показания:
        <label><?=$replay['result'][0]['UF_CRM_1550321518']?></label>
        <?=($replay['result'][0]['UF_CRM_1550321518'] == "Норма")?"<img width='130' alt='Зрение для Знаний' src='https://rest.key-persons.ru/zdz/results/img/_.png'>":$replay['result'][0]['UF_CRM_1552244232']?>
      </div>
    </div>
    <div class="row-flex">
      <div class="item-flex w100">
        <p>Комментарий:&nbsp;<?=$replay['result'][0]['COMMENTS']?></p>
      </div>
    </div>
  </div>
</div>
<?if ($replay['result'][0]['UF_CRM_1549866002'] == "Норма" && $replay['result'][0]['UF_CRM_1550321518'] =="Норма"){?>
<div class="panel-info">
  <div class="block-info">
    <img width="49" alt="Зрение для Знаний" src="https://rest.key-persons.ru/zdz/results/img/greendot2.png" height="15" style="margin-bottom: 10px;">
    <p>Поздравляем Ваш ребенок успешно прошел тестирование зрения.</p>
    <p>Вместе с тем, обращаем Ваше внимание, что при наличии жалоб от ребенка, рекомендуем обратиться к врачу по месту прописки или в специализированную клинику.</p>
  </div>
</div>
<div class="panel-info">
  <p><b>Увидимся в следующем году!</b></p>
</div>
<div class="line"></div>
<?}else{
      /*Ищем ID копии сделки в направлении "Отклонения"*/
      $queryUrl = 'https://zdz-online.bitrix24.ru/rest/16/opxrg0lm0un683us/crm.deal.list.json/';
      $queryData = http_build_query(
        array( 
          'order' => array("ID"=>"DESC"),
          'filter' => array("CATEGORY_ID" => 8,"UF_CRM_5ABC6DAD6F1EC"=>"AAATDG"),
          'select' => array(
            "ID", "BEGINDATE"
          )
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
      
      $dealCopy = json_decode(curl_exec($curl), true);
      curl_close($curl);
      /*------------------------------------------------*/
      //$replay['result']['0']['ID']
      file_get_contents("https://zdz-online.bitrix24.ru/rest/1/qs44feeuf4w6if93/crm.automation.trigger/?target=DEAL_".$dealCopy['result']['0']['ID']."&code=3cxt6");//Срабатывание тригера

?>
<div class="panel-info">
  <div class="block-info">
    <p><?=$replay['result'][0]['UF_CRM_1550485084']?></p>
  </div>
</div>
<div class="panel-info">
  <div class="block-info">
    <p><?=$replay['result'][0]['UF_CRM_1550485124']?></p>
  </div>
</div>
<div class="panel-info panel-info-block">
  <div class="block-info">
    <img width="49" alt="Зрение для Знаний" src="https://rest.key-persons.ru/zdz/results/img/bluedot2.png" height="15" style="margin-bottom: 10px;">
    <p>По результатам скрининга <b>выявлены отклонения от нормы</b>. Рекомендуем <b>обратиться к врачу</b> по месту медицинского обслуживания или в специализированную клинику для проведения второго этапа обследования.</p>
  </div>
</div>
<div class="panel-info">
  <p><b>Желаем Вашему ребенку здоровья!</b></p>
</div>
<div class="panel-socnetwork panel-info-block">
  <h4 class="text-uppercase text-center">Нажмите для записи к вашему врачу:</h4>
  <div class="block-socnetwork">
    <a href="https://vk.me/club180218409"><img width="80" alt="Зрение для Знаний" src="https://1fms.com/upload/medialibrary/178/vk.png" border="0"></a> 
    <a href="https://m.me/320684418530318"><img width="80" alt="Зрение для Знаний" src="https://1fms.com/upload/medialibrary/0f4/fb.png" border="0"></a> 
    <a href="https://1fms.com/zdzredirect/"><img width="80" alt="Зрение для Знаний" src="https://1fms.com/upload/medialibrary/a9a/viber.png" border="0"></a> 
    <a href="https://tele.click/zdzonlineRegistraturaBot"><img width="80" alt="Зрение для Знаний" src="https://1fms.com/upload/medialibrary/701/tele.png" border="0"></a>
  </div>
  <div class="panel-info">
    <div class="block-info text-center">
      <?=$user['result'][0]['WORK_POSITION']?>
    </div>
  </div> 
</div>
<?}
//UF_CRM_1579668237 - дата/время просмотра результатов
//UF_CRM_1579668211 - счетчик просмотров
?>
<div class="panel-info panel-check">
  <div class="block-info text-center">
    <b>Распечатка измерений аппарата <br>Righton RetinoMax K-3 Plus</b>
  </div>
  <div class="block-result-test">
    <div><?=$replay['result'][0]['UF_CRM_1550760923']?></div>
    <div id="printPDF" class="block-result-test_bottom text-center">ПОВЕРКА ФБУ РОСТЕСТ МОСКВА №СП2574020</div>
    <!--<div style="display:none" class="block-info text-center">
      <button id="printPDF">Печать результатов</button>
      <a href="https://rest.key-persons.ru/zdz/results/makepdf.php?agreementId=<?=$_POST['agreementId']?>&dealId=<?=$_POST['dealId']?>" target="_blanc">Скачать отчет</a>
    </div>-->
  </div>
</div>
<?} else echo "error";}?>