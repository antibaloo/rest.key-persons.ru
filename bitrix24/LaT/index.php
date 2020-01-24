<?php
if (!substr_count($_REQUEST['DOMAIN'],'.bitrix24.ru')) die("ПНХ!");
?>
<!doctype html>
<html lang="ru">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,600,700&subset=latin,cyrillic" rel="stylesheet" type="text/css">
    <link href="css/lat.css?ver=<?=time()?>" rel="stylesheet">
  </head>
  <body>
    <div id="app" class="container-fluid">
      <div class="bs-callout bs-callout-info">
        <p>Текущий пользователь: <span id="user-name"></span></p>
      </div>
      <div class="tabs">
        <input id="tab1" type="radio" name="tabs" checked>
        <label for="tab1" title="Wordpress">Курсы</label>
        <input id="tab2" type="radio" name="tabs">
        <label for="tab2" title="Windows">Тесты</label>
        <input id="tab3" type="radio" name="tabs">
        <label for="tab3" title="HTML5">Статистика</label>
        <input id="tab4" type="radio" name="tabs">
        <label for="tab4" title="CSS3">Настройки</label>
        <section id="content-tab1">
          <p> WordPress — система управления содержимым сайта с открытым исходным кодом, распространяемая под GNU GPL. Написана на PHP, в качестве базы данных использует MySQL. </p>
          <p> Сфера применения — от блогов до достаточно сложных новостных ресурсов и интернет-магазинов. Встроенная система «тем» и «плагинов» вместе с удачной архитектурой позволяет конструировать практически любые проекты. WordPress выпущен под лицензией GPL версии 2. </p>
        </section>
        <section id="content-tab2">
          <p> Microsoft Windows (произносится [майкрософт ви́ндоус]) — семейство проприетарных операционных систем корпорации Microsoft, ориентированных на применение графического интерфейса при управлении. </p>
          <p> Изначально Windows была всего лишь графической надстройкой для MS-DOS. По состоянию на март 2013 года под управлением операционных систем семейства Windows по данным ресурса NetMarketShare (Net Applications) работает около 90 % персональных компьютеров[1]. Операционные системы Windows работают на платформах x86, x86-64, IA-64, ARM. </p>
        </section>
        <section id="content-tab3">
          <p> HTML5 (англ. HyperText Markup Language, version 5) — язык для структурирования и представления содержимого всемирной паутины. Это пятая версия HTML, последняя (четвёртая) версия которого была стандартизирована в 1997 году. По состоянию на октябрь 2013 года, HTML5 ещё находится в разработке, но, фактически, является рабочим стандартом (англ. HTML Living Standard). Цель разработки HTML5 — улучшение уровня поддержки мультимедиа-технологий, сохраняя при этом удобочитаемость кода для человека и простоту анализа для парсеров. </p>
          <p> Во всемирной паутине долгое время использовались стандарты HTML 4.01 и XHTML 1.1, и веб-страницы на практике оказывались свёрстаны с использованием смеси особенностей, представленных различными спецификациями, включая спецификации программных продуктов, например веб-браузеров, а также сложившихся общеупотребительных приёмов. HTML5 был создан, как единый язык разметки, который мог бы сочетать синтаксические нормы HTML и XHTML. Он расширяет, улучшает и рационализирует разметку документов, а также добавляет единое API для сложных веб-приложений. </p>
        </section>
        <section id="content-tab4">
          <p> Спецификация CSS3 — это неоспоримое будущее в области декоративного оформления веб-страниц, и ее разработка еще далека от завершения. Большинство модулей все еще продолжает совершенствоваться и модифицироваться, и ни один браузер не поддерживает все модули. Это означает, что CSS3 испытывает такие же сложности, как и HTML5. Веб-разработчикам нужно решать, какие возможности использовать, а какие игнорировать, а также каким образом заполнить зияющие пробелы в браузерной поддержке. </p>
          <p> CSS3 не является частью спецификации HTML5. Эти два стандарта были разработаны отдельно друг от друга, разными людьми, работающими в разное время в различных местах. Но даже организация W3C призывает веб-разработчиков использовать HTML5 и CSS3 вместе, как часть одной новой волны современного веб-дизайна. </p>
        </section>
      </div>
    </div>
  </body>
  <script src="//api.bitrix24.com/api/v1/"></script>  
  <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
  <script src="js/lat.js?ver=<?=time()?>"></script>
</html>