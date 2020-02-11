function $_GET(key) {
  var s = window.location.search;
  s = s.match(new RegExp(key + '=([^&=]+)'));
  return s ? s[1] : false;
}
$(document).ready(function(){
  // текущая дата
  var date = new Date();
  $("#copyright").html('© АНО "ФЦ "Зрение для Знаний" 2018-'+date.getFullYear());
  var agreementId = $_GET('agreementId');
  var dealId = $_GET('dealId');
  $.ajax({
    url: "https://rest.key-persons.ru/zdz/results/ajax.php",
    type: "POST",
    data: {
      agreementId: agreementId,
      dealId: dealId
    },
    dataType: "text",
    success: function (data) {
      if (data !='error'){
        $("#results").html(data);
      }else{
        $("#results").html("<center><h1 style='color:red;'>СТРАНИЦА НЕ НАЙДЕНА!!!</h1></center");
        //$("#results").css("height", "100vh")
      }
    },
    error: function (data) {
      ym(57468781, 'reachGoal', 'fatalError');
      $("#results").html("<center><h1 style='color:green;'>На сайте ведутся техничекие работы. Повторите попытку позднее.</h1></center");
    },
  });
  $("#toPDF").on('click','#printPDF',function(){
    const filename  = 'ThisIsYourPDFFilename.pdf';
    var element = $("#toPDF")[0];
    $("#share").hide();
    window.scrollTo(0,0);
    html2canvas(document.body).then(canvas => {
      document.body.appendChild(canvas);
      //console.log(canvas.toDataURL('image/png'));
      var doc = new jsPDF();      
      var imgSampleData =canvas.toDataURL('image/png');
      doc.addImage(imgSampleData, 'PNG', -92.5, 0, 400, 297);
      doc.save('report.pdf');
      
      $.ajax({
        url: "https://rest.key-persons.ru/zdz/results/makepdf.php",
        type: "POST",
        data: {
          image: canvas.toDataURL('image/png'),
        },
        dataType: "text",
        success: function (data) {
          if (data !='error'){
            //window.open("data:application/pdf," + data); 
            /*var url = window.URL.createObjectURL(new Blob([data], {type: 'application/pdf'}));
            $("#results").html("<a href='"+url+"' download='Report'>Download report</a>");
            window.URL.revokeObjectURL(url);*/
            //$("#results").html(data);
          }else{
            $("#results").html("<center><h1 style='color:red;'>СТРАНИЦА НЕ НАЙДЕНА!!!</h1></center");
            //$("#results").css("height", "100vh")
          }
        },
        error: function (data) {
          console.log(data);
          $("#results").html("<center><h1 style='color:red;'>Фатальная ошибка: обратитесь к администратору!</h1></center");
        },
      });
      
      
      //let pdf = new jsPDF('p', 'mm', 'a4');
			//pdf.addImage(canvas.toDataURL('image/png'), 'PNG', 0, 0, 2100, 2970);
			//pdf.save(filename);
		});
    $("#share").show();
    window.scrollTo(0, document.body.scrollHeight || document.documentElement.scrollHeight);
    
    
    // Choose the element that our invoice is rendered in.
    //const element = document.getElementById("toPDF");
    // Choose the element and save the PDF for our user.
    //html2pdf().set({ html2canvas: { scale: 4 } }).from(element).save("test.pdf");
  });
});