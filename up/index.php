
<form>
  Реальная стоимость квартиры <input id="rPrice" type="number" step="5000" value="1000000"><br>
  Сумма наличных средств у покупателя <input id="rPV" type="number" step="5000"><br>
  Необходимые ипотечные средства <input id="rIpoteka" type="number" readonly><br>
  % ПВ банка <input id="pPV" type="number" min="10" max="20" step="1" value="20"><br>
  Необходимая оценочная стоимость <input id="cPrice" type="number" readonly><br>
  Первый взнос по расписке для банка <input id="PV" type="number" readonly><br>
  <a href="javascript:calculate();">
    Расчитать
  </a>
</form>
<script
  src="https://code.jquery.com/jquery-3.3.1.js"
  integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
  crossorigin="anonymous"></script>
<script>
  function calculate(){
    $("#rIpoteka").val($("#rPrice").val()-$("#rPV").val());
    $("#cPrice").val($("#rIpoteka").val()/(1-$("#pPV").val()/100));
    $("#PV").val($("#cPrice").val()-$("#rIpoteka").val());
  }
</script>