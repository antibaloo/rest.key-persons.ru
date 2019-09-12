<!doctype html>
<html lang="ru">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="kreditCalc.css?ver=<?=time()?>" rel="stylesheet">
  </head>
  <body>
    <div class="parent">
      <div class="left">
        <h3>Расчет завышения ипотеки:</h3>
        <form>
          <div class="form-group">
            <label for="rPrice">Реальная стоимость квартиры</label>
            <input type="number" class="form-control" id="rPrice" aria-describedby="rPriceHelp" step="5000">
            <!--<small id="rPriceHelp" class="form-text text-muted">Сумма которую хочет получить продавец на руки</small>-->
          </div>
          <div class="form-group">
            <label for="rPV">Сумма наличных средств у покупателя</label>
            <input type="number" class="form-control" id="rPV" aria-describedby="rPVHelp" step="5000">
            <!--<small id="rPVHelp" class="form-text text-muted">Сколько наличных есть у покупателя, реальная сумма</small>-->
          </div>
          <div class="form-group">
            <label for="rIpoteka">Необходимые ипотечные средства</label>
            <input type="number" class="form-control" id="rIpoteka" aria-describedby="rIpotekaHelp" readonly>
            <!--<small id="rIpotekaHelp" class="form-text text-muted">Сумма, которая должна быть одобрена банком</small>-->
          </div>
          <div class="form-group">
            <label for="pPV">% ПВ банка</label>
            <input type="number" class="form-control" id="pPV" aria-describedby="pPVHelp" min="10" max="30" step="1" value="20">
            <!--<small id="pPVHelp" class="form-text text-muted">Какой процент от стоимости должен составлять первый взнос</small>-->
          </div>
          <div class="form-group">
            <label for="cPrice">Оценочная стоимость</label>
            <input type="number" class="form-control" id="cPrice" aria-describedby="cPriceHelp" readonly>
            <!--<small id="cPriceHelp" class="form-text text-muted">Какая стоимость объекта должна быть по оценке</small>-->
          </div>
          <div class="form-group">
            <label for="PV">Первоначальный взнос по расписке для банка</label>
            <input type="number" class="form-control" id="PV" aria-describedby="PVHelp" readonly>
            <!--<small id="PVHelp" class="form-text text-muted">Сумма в расписке для банка</small>-->
          </div>
          <a class="btn btn-primary" href="javascript:calculate();">Рассчитать</a>
        </form>
      </div>
      <div class="right">
        <h3>Расчет кредитных платежей:</h3>
        <form>
          <div class="form-group">
            <label for="creditSum">Сумма кредита</label>
            <input type="number" class="form-control" id="creditSum" step="5000">
          </div>
          <div class="form-group">
            <label for="percentCredit">Процентная ставка</label>
            <input type="number" class="form-control" id="percentCredit" min="0.01" max="100" step="0.01">
          </div>
          <div class="form-group">
            <label for="periodCredit">Срок кредита в месяцах</label>
            <input type="number" class="form-control" id="periodCredit" min="1" step="1">
          </div>
          <div class="form-group">
            <label for="annPlatezh">Аннуитетный платеж</label>
            <input type="number" class="form-control" id="annPlatezh" readonly>
          </div>
          <div class="form-group">
            <label for="diffPlatezh">Максимальный дифференцированный платеж</label>
            <input type="number" class="form-control" id="diffPlatezh" readonly>
          </div>
          <a class="btn btn-primary" href="javascript:platezh();">Рассчитать</a>
        </form>
      </div>
    </div>
  </body>
  <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
  <script>
    function calculate(){
      $("#rIpoteka").val($("#rPrice").val()-$("#rPV").val());
      $("#cPrice").val($("#rIpoteka").val()/(1-$("#pPV").val()/100));
      $("#PV").val($("#cPrice").val()-$("#rIpoteka").val());
    }
    function platezh(){
      $("#diffPlatezh").val($("#creditSum").val()/$("#periodCredit").val()+$("#creditSum").val()*$("#percentCredit").val()/12/100);
      $("#annPlatezh").val($("#creditSum").val()*($("#percentCredit").val()/100/12+$("#percentCredit").val()/100/12/(Math.pow(1+$("#percentCredit").val()/100/12,$("#periodCredit").val())-1)));
    }
  </script>
</html>