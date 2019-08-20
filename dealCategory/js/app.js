$(document).ready(function(){
  /*BX24.callMethod(
    "crm.dealcategory.add",{
      fields:{"NAME":"Самое новое направление", "SORT":"20", "IS_LOCKED": "N"}
    },
    function(result){
      if(result.error()) console.error(result.error());
      else console.info("Создано направление с ID " + result.data());
    }
  );*/
  BX24.callMethod(
    "crm.dealcategory.list",{ 
      order: { "SORT": "ASC" },
      filter: {},
      select: ["*"/**/]
    }, 
    function(result) {
      if(result.error()) console.error(result.error());
      else{
        console.dir(result.data());
        if(result.more())	result.next();
      }
    }
  );
  BX24.callMethod(
           "crm.dealcategory.default.get", 
           {}, 
           function(result) 
           {
               if(result.error())
                   console.error(result.error());
               else
                   console.dir(result.data());
           }
       );
BX24.callMethod(
	"crm.dealcategory.stage.list", 
	{ id: 2 }, 
	function(result) 
	{
		if(result.error())
			console.error(result.error());
		else
			console.dir(result.data());
	}
);
  BX24.callMethod(
	"crm.dealcategory.stage.list", 
	{ id: 4 }, 
	function(result) 
	{
		if(result.error())
			console.error(result.error());
		else
			console.dir(result.data());
	}
);

});