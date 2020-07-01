BX24.init(function(){
	//console.log('Инициализация завершена!', BX24.isAdmin());
  $("#apiKey").val(BX24.appOption.get('token'));
 //Тест юнит поиска лида
  BX24.callMethod(
			"crm.lead.list",{ 
				order: {},
				filter: { "SOURCE_DESCRIPTION": "17401392"},
				select: [ "ID", "TITLE", "STATUS_ID", "SOURCE_ID", "SOURCE_DESCRIPTION"]
			}, 
			function(result) 
			{
				if(result.error())
					console.error(result.error());
				else
				{
					if (result.data().length>0) console.dir(result.data()[0]);			
          else console.log("Не найден результат!");
					if(result.more())
						result.next();						
				}
			}
		);
  
  
  //Тест юнит перебора лидов
  /*var count = 58;
  var limit = count < 50? count: 50;
  var offset = 0;
  do { 
    if (count < limit) limit = count;
    console.log("request?offset="+offset+"&limit="+limit);
    count-=limit;
    offset+=limit;
  } while (count>0)*/
  
  // Получение списка активных предзаказов
  $.ajax({
    url: 'apiRequests.php',
    type: "POST",
    data: {
      action: 'preorders',
      token: BX24.appOption.get('token'),
    },
    success: function(data){
      result = JSON.parse(data);
      if (result.status=="success") {
        //Обработка списка предзаказов
        console.log(result.preorders);
        result.preorders.forEach(function(item){
          $("#preorders").append("<div class='row preorder' id='"+item.id+"' leadsCount='"+item.count_today+"'></div>");
          $("#"+item.id).append("<div>"+item.id+"</div><div>"+item.city_name+"</div><div>"+item.count_today+"</div><div>"+item.count_total+"</div><div>"+item.lead_price+"</div>");
        });
        $("#error").html("<span style='color:green;'>Предзаказы получены.</span>");
      }
      if (result.status=="error") $("#error").html("<span style='color:red;'>"+result.message+"</span>");//process the JSON data etc
    },
    error: function (data){
      $("#error").html("<span style='color:red;'>"+data+"</span>");
    } 
  });
  
  $("#authorization").on('click',function(){
    $.ajax({
      url: 'apiRequests.php',
      type: "POST",
      data: {
        action: 'authorization',
        email: BX24.appOption.get('email'),
        password: BX24.appOption.get('password')
      },
      success: function(data){
        result = JSON.parse(data);
        if (result.status=="success") {
          $("#apiKey").val(result.token);
          BX24.appOption.set("token",result.token);
          $("#error").html("<span style='color:green;'>Успешная авторизация.</span>");
        }
        if (result.status=="error") $("#error").html("<span style='color:red;'>"+result.message+"</span>");//process the JSON data etc
      },
      error: function (data){
        $("#error").html("<span style='color:red;'>"+data+"</span>");
      } 
    });
  });
  $("#preorders").on('click', '.preorder', function(){
    console.log($(this).attr("id"));
    $.ajax({
      url: 'apiRequests.php',
      type: "POST",
      data: {
        action: 'leads',
        token: BX24.appOption.get('token'),
        preorderId: $(this).attr("id"),
        leadsCount: 25/*$(this).attr("leadsCount")*/,
      },
      success: function(data){
        result = JSON.parse(data);
        if (result.status=="success") {
          //Обработка списка лидов
          console.log(result.leads);
          var crmLeadId;
          result.leads.forEach(function(item){
            
            BX24.callMethod(
              "crm.lead.list",{
                order: {},
                filter: { "SOURCE_DESCRIPTION": item.id},
                select: [ "ID", "TITLE", "STATUS_ID", "SOURCE_ID", "SOURCE_DESCRIPTION"]
              }, 
              function(res){
                if(res.error())console.error(res.error());
                else{
                  if (res.data().length>0){
                    console.dir(result.data()[0]);
                    crmLeadId = res.data()[0].ID;
                    $("#leads").append("<div class='row lead' id='"+item.id+"'></div>");
                    $("#"+item.id).append("<div>"+item.id+"</div><div>"+crmLeadId+"</div><div>"+item.name+"</div><div>"+item.phone+"</div><div>"+item.question_text+"</div><div></div>");
                  }
                  if(res.more()) res.next();
                }
              }
            );
            
          });
          $("#error").html("<span style='color:green;'>Лиды получены.</span>")
        }
        if (result.status=="error") $("#error").html("<span style='color:red;'>"+result.message+"</span>");//process the JSON data etc
      },
      error: function(data){
        $("#error").html("<span style='color:red;'>"+data+"</span>");
      }
    });
  });
});