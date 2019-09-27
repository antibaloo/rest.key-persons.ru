<?if($_POST['agreementId'] =="false"|| $_POST['dealId'] == "false"){?>
<center><h1 style='color:red;'>Эта страница отсутствует на сервере!</h1></center>
<?}else{
  $queryUrl = 'https://zdz-online.bitrix24.ru/rest/16/opxrg0lm0un683us/crm.deal.list.json/';
  $queryData = http_build_query(
    array( 
      'order' => array("ID"=>"DESC"),
      'filter' => array("ID" => $_POST['dealId'],"UF_CRM_5ABC6DAD6F1EC"=>$_POST['agreementId']),
      'select' => array(
        "ID",
        "UF_CRM_5ABC6DAD6F1EC",   //ID согласия
        "STAGE_ID", 
        "UF_CRM_5B1B9EE8CFA0A",   //Имя ребенка
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
    //if ($replay['result'][0]['UF_CRM_1549866002'] == "Норма" && $replay['result'][0]['UF_CRM_1550321518'] == "Норма")
?>
<table cellpadding="0" cellspacing="0" width="100%">
  <tbody>
    <tr>
      <td>
        <table align="center" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc;">
          <tbody>
            <tr align="center" bgcolor="#a9d9fc">
              <td style="padding: 10px 0px 10px 0px;">
                <img width="150" alt="Зрение для Знаний" src="http://1fms.com/upload/medialibrary/f8e/logoemail.png" height="147">
              </td>
            </tr>
            <tr>
              <td bgcolor="#ffffff" style="padding: 30px 30px 40px 30px;">
                <table cellpadding="0" cellspacing="0" width="100%" style="font-size: 100%; font-family: Verdana, Arial, Helvetica, sans-serif; /* Семейство шрифта */ color: #000000; /* Цвет текста */">
                  <tbody>
                    <tr>
                      <td>
                        <h2>РЕЗУЛЬТАТЫ СКРИНИНГА ЗРЕНИЯ ВАШЕГО РЕБЁНКА</h2>
                        <img width="94" alt="Зрение для Знаний" src="http://1fms.com/upload/medialibrary/e8d/dotline2.png" height="15">Согласие <?=$replay['result'][0]['UF_CRM_5ABC6DAD6F1EC']?>
                      </td>
                    </tr>
                    <tr>
                      <td style="padding: 40px 0 10px 0;">
                        <table cellpadding="0" cellspacing="0" width="100%">
                          <tbody>
                            <tr>
                              <td width="260" valign="top">
                                Имя ребенка: <b><?=$replay['result'][0]['UF_CRM_5B1B9EE8CFA0A']?></b><br>
                                Дата рождения:&nbsp; <?=date("d.m.Y",strtotime($replay['result'][0]['UF_CRM_5B1B9EE8E5EC2']))?><br>
                                Школа: <?=$replay['result'][0]['UF_CRM_5BB1B8D60CD7F']?>
                              </td>
                              <td style="font-size: 0; line-height: 0;" width="20">
                                &nbsp;
                              </td>
                              <td width="260" valign="top">
                                <?=$user['result'][0]['WORK_POSITION']?>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                    <tr>
                      <td style="padding: 30px 10px 10px 10px;">
                        <h3>Уважаемый родитель!</h3>
                        <p>
                          Сегодня Ваш ребенок прошел обследование зрения с использованием высокоточного оборудования Righton RetinoMax Plus K-3 (Япония) в рамках проведения ежегодного профилактического осмотра, с целью выявления болезней глаз на ранней стадии в течение учебного года.
                        </p>
                        Мы получили следующие результаты скрининга Вашего ребенка:
                      </td>
                    </tr>
                    <tr>
                      <td align="center" style="padding: 10px 0 10px 0;">
                        <table style=" font-size: 90%; border-style: solid; border-width: 1px 1px 1px 1px; border-color: #CCCCCC;border-radius: 20px; border-spacing: 0; text-align: center; ">
                          <tbody align="center">
                            <tr>
                              <td width="180" style="padding: 10px; border-right: dotted 1px;">
                                Правый глаз
                              </td>
                              <td width="180" style="padding: 10px">
                                Левый глаз
                              </td>
                            </tr>
                            <tr>
                              <td style="background: #eeeeee; padding: 10px; border-right: dotted 1px;">
                                SPH&nbsp;<?=$replay['result'][0]['UF_CRM_1550386626']?>
                              </td>
                              <td style="background: #eeeeee; padding: 10px;">
                                SPH&nbsp;<?=$replay['result'][0]['UF_CRM_1550386686']?>
                              </td>
                            </tr>
                            <tr>
                              <td style="background: #eeeeee; padding: 10px; ; border-right: dotted 1px;">
                                СYL&nbsp;<?=$replay['result'][0]['UF_CRM_1550386670']?>
                              </td>
                              <td style="background: #eeeeee; padding: 10px;">
                                СYL&nbsp;<?=$replay['result'][0]['UF_CRM_1550386706']?>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="2" style="padding: 10px;">
                                Результаты проверочной таблицы
                              </td>
                            </tr>
                            <tr>
                              <td style="background: #eeeeee; padding: 10px; border-right: dotted 1px;">
                                <?=$replay['result'][0]['UF_CRM_1549866056']?><br>
                              </td>
                              <td style="background: #eeeeee; padding: 10px;">
                                <?=$replay['result'][0]['UF_CRM_1549866088']?><br>
                              </td>
                            </tr>
                            <tr>
                              <td style="padding: 20px; border-right: dotted 1px;">
                                Показания:<br>
                                <strong><?=$replay['result'][0]['UF_CRM_1549866002']?></strong><br>
                                <br>
                                <?=($replay['result'][0]['UF_CRM_1549866002'] == "Норма")?"<img width='130' alt='Зрение для Знаний' src='http://1fms.com/upload/medialibrary/eb2/_.png'>":$replay['result'][0]['UF_CRM_1552244208']?><br>
                              </td>
                              <td style="padding: 20px;">
                                Показания:<br>
                                <strong><?=$replay['result'][0]['UF_CRM_1550321518']?></strong><br>
                                <br>
                                  <?=($replay['result'][0]['UF_CRM_1550321518'] == "Норма")?"<img width='130' alt='Зрение для Знаний' src='http://1fms.com/upload/medialibrary/eb2/_.png'>":$replay['result'][0]['UF_CRM_1552244232']?><br>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="2" style=" padding: 10px;">
                                Комментарий:&nbsp;<?=$replay['result'][0]['COMMENTS']?>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                    <?if ($replay['result'][0]['UF_CRM_1549866002'] == "Норма" && $replay['result'][0]['UF_CRM_1550321518'] =="Норма"){?>
                    <tr>
                      <td style="padding: 10px">
                        <br>
                        <img width="49" alt="Зрение для Знаний" src="http://1fms.com/upload/medialibrary/3f6/greendot2.png" height="15">
                        <p>
                          Поздравляем Ваш ребенок успешно прошел тестирование зрения.
                        </p>
                        Вместе с тем, обращаем Ваше внимание, что при наличии жалоб от ребенка, рекомендуем обратиться к врачу по месту прописки или в специализированную клинику.
                        <p>
                          <b>Увидимся в следующем году!</b>
                        </p>
                      </td>
                    </tr>
                    <?}else{?>
                    <tr>
                      <td style="padding: 10px">
                        <br>
                        <?=$replay['result'][0]['UF_CRM_1550485084']?><br>
                        <br>
                        <?=$replay['result'][0]['UF_CRM_1550485124']?><br>
                        <br>
                        <img width="49" alt="Зрение для Знаний" src="http://1fms.com/upload/medialibrary/a3a/bluedot2.png" height="15">
                        <p>
                          По результатам скрининга <b>выявлены отклонения от нормы</b>. Рекомендуем <b>обратиться к врачу</b> по месту медицинского обслуживания или в специализированную клинику для проведения второго этапа обследования.
                        </p>
                        <p>
                          <b>Желаем Вашему ребенку здоровья!</b>
                        </p>
                      </td>
                    </tr>
                    <tr align="center">
                      <td style="padding: 20px;">
                        <hr style="border: none;color: #a9d9fc;background-color: #FF2C29;height: 10px;">
                        НАЖМИТЕ ДЛЯ ЗАПИСИ К ВАШЕМУ ВРАЧУ:<br>
                        <br>
                        <a href="http://vk.me/club180218409"><img width="80" alt="Зрение для Знаний" src="http://1fms.com/upload/medialibrary/178/vk.png" border="0"></a> <a href="http://m.me/320684418530318"><img width="80" alt="Зрение для Знаний" src="http://1fms.com/upload/medialibrary/0f4/fb.png" border="0"></a> <a href="http://1fms.com/zdzredirect/"><img width="80" alt="Зрение для Знаний" src="http://1fms.com/upload/medialibrary/a9a/viber.png" border="0"></a> <a href="https://tele.click/zdzonlineRegistraturaBot"><img width="80" alt="Зрение для Знаний" src="http://1fms.com/upload/medialibrary/701/tele.png" border="0"></a>
                        <p>
                          <small><?=$user['result'][0]['WORK_POSITION']?></small>
                        </p>
                        <hr style="border: none;color: #a9d9fc;background-color: #FF2C29;height: 10px;">
                      </td>
                    </tr>
                    <?}?>
                    <tr>
                      <td align="center" style="padding: 15px">
                        Распечатка измерений аппарата <br>
                        Righton RetinoMax K-3 Plus<br>
                        <br>
                        <table border="1" cellpadding="0" cellspacing="0" width="200">
                          <tbody>
                            <tr>
                              <td style="font-size: 0; line-height: 0;" width="200">
                                &nbsp;
                              </td>
                            </tr>
                            <tr>
                              <td style=" font-size: 80%; padding: 25px">
                                <pre><?=$replay['result'][0]['UF_CRM_1550760923']?></pre>
                              </td>
                            </tr>
                            <tr>
                              <td align="center" style="font-size: 50%; padding: 2px">
                                ПОВЕРКА ФБУ РОСТЕСТ МОСКВА №СП2574020 до 03.02.2020
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </td>
            </tr>
            <tr>
              <td align="center" bgcolor="#a9d9fc" style="padding: 3px; font-family: Verdana, Arial, Helvetica, sans-serif; /* Семейство шрифта */ color: #000000; /* Цвет текста */">
                <small>© АНО "ФЦ "Зрение для Знаний" 2018</small>
              </td>
            </tr>
          </tbody>
        </table>
      </td>
    </tr>
  </tbody>
</table>
<?
  } else echo "error";}
?>