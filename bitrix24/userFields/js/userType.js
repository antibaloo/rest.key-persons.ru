//Очистка списка полей лида
function clearLeadUserFieldsList(){
  $("#leadUserFieldsList").find("li").remove();
}
//Загрузка списка полей лида
function loadLeadUserFieldsList(){
  BX24.callMethod(
    "crm.lead.userfield.list", 	
    { 
      order: { "SORT": "ASC" },
      filter: {}
    }, 
    function(result){
      if(result.error()) console.error(result.error());
      else{
        result.data().forEach(function (field){
          BX24.callMethod(
            "crm.lead.userfield.get", 
            {id: field.ID},
            function(result){
              var s = '';
              s += '<b>' + result.query.method + '</b>\n';
              s += JSON.stringify(result.query.data, null, '  ') + '\n\n';
              if(result.error()){
                s += '<span style="color: red">Error! ' + result.error().getStatus() + ': ' + result.error().toString() + '</span>\n';
                $("#messages").html(s);
              }else
                $('#leadUserFieldsList').append('<li class="userField" entityid="'+field.ENTITY_ID+'" fieldid="'+field.ID+'" fieldname="'+field.FIELD_NAME+'" usertypeid="'+field.USER_TYPE_ID+'" fieldlabel="'+result.data().EDIT_FORM_LABEL.ru+'" fieldmandatory="'+field.MANDATORY+'" fieldmultiple="'+field.MULTIPLE+'">'+result.data().EDIT_FORM_LABEL.ru+'</li>');
            }
          );
        });
        if(result.more())	result.next();
      }
    }
  );
}
//Очистить форму пользовательского поля лида
function clearLeadUserFieldForm(){
  $("#leadUserFieldsList").find("li").each(function(){$(this).css("border","1px solid white");});
  $("#leadFieldId").val("");
  $("#leadFieldName").val("");
  $("#leadFieldName").prop("readonly", false);
  $("#leadFieldLabel").val("");
  $('#leadFieldMandatory').prop('checked', false);
  $('#leadFieldMultiple').prop('checked', false);
  $("#leadFieldType").val("");
  $("#addLeadUserField").html("Добавить");
  $("#deleteLeadUserField").addClass("disabled");
}
//Очистка списка полей сделки
function clearDealUserFieldsList(){
  $("#dealUserFieldsList").find("li").remove();
}
//Загрузка списка полей сделки
function loadDealUserFieldsList(){
  BX24.callMethod(
    "crm.deal.userfield.list", 	
    { 
      order: { "SORT": "ASC" },
      filter: {}
    }, 
    function(result){
      if(result.error()) console.error(result.error());
      else{
        result.data().forEach(function (field){
          BX24.callMethod(
            "crm.deal.userfield.get", 
            {id: field.ID},
            function(result){
              var s = '';
              s += '<b>' + result.query.method + '</b>\n';
              s += JSON.stringify(result.query.data, null, '  ') + '\n\n';
              if(result.error()){
                s += '<span style="color: red">Error! ' + result.error().getStatus() + ': ' + result.error().toString() + '</span>\n';
                $("#messages").html(s);
              }else
                $('#dealUserFieldsList').append('<li class="userField" entityid="'+field.ENTITY_ID+'" fieldid="'+field.ID+'" fieldname="'+field.FIELD_NAME+'" usertypeid="'+field.USER_TYPE_ID+'" fieldlabel="'+result.data().EDIT_FORM_LABEL.ru+'" fieldmandatory="'+field.MANDATORY+'" fieldmultiple="'+field.MULTIPLE+'">'+result.data().EDIT_FORM_LABEL.ru+'</li>');
            }
          );
        });
        if(result.more())	result.next();
      }
    }
  );
}
//Очистить форму пользовательского поля сделки
function clearDealUserFieldForm(){
  $("#dealUserFieldsList").find(".userField").each(function(){$(this).css("border","1px solid white");});
  $("#dealFieldId").val("");
  $("#dealFieldName").val("");
  $("#dealFieldName").prop("readonly", false);
  $("#dealFieldLabel").val("");
  $('#dealFieldMandatory').prop('checked', false);
  $('#dealFieldMultiple').prop('checked', false);
  $("#dealFieldType").val("");
  $("#addDealUserField").html("Добавить");
  $("#deleteDealUserField").addClass("disabled");
}
//Очистка списка типов пользовательских полей
function clearUserFieldTypes (){
  $("#leadFieldType").find("option").remove();
  $("#dealFieldType").find("option").remove();
}
//Загрузка списка типов пользовательских полей
function loadUserFieldTypes(){
  BX24.callMethod(
    'crm.userfield.types',
    {},
    function (result){
      var s = '';
      s += '<b>' + result.query.method + '</b>\n';
      s += JSON.stringify(result.query.data, null, '  ') + '\n\n';
      if(result.error()){
        s += '<span style="color: red">Error! ' + result.error().getStatus() + ': ' + result.error().toString() + '</span>\n';
        $("#messages").html(s);
      }else{
        $('#leadFieldType').append('<option value="" selected>выберите тип поля</option>');
        $('#dealFieldType').append('<option value="" selected>выберите тип поля</option>');
        result.data().forEach(function(item){
          $('#leadFieldType').append('<option value="'+item.ID+'">'+item.title+'</option>');
          $('#dealFieldType').append('<option value="'+item.ID+'">'+item.title+'</option>');
        });
        if(result.more())	result.next();
      }
    }
  );
}
//Очистка списка пользовательских типов
function clearUserTypes(){
  $("#userTypesList").find("li").remove();
}
//Загрузка списка пользовательских типов
function loadUserTypes(){
  BX24.callMethod(
    'userfieldtype.list', 
    {}, 
    function(result){
      console.log(result.data());
    }
  );
}
//Очистка формы пользовательских типов
function clearUserTypeForm(){
  
}

BX24.ready(function(){
  BX24.init(function(){
    //Загрузка списка типов пользовательских полей
    loadUserFieldTypes();
    //Загрузка списка пользовательских полей в лидах
    loadLeadUserFieldsList();
    //Загрузка списка пользовательских полей в сделках
    loadDealUserFieldsList();
    //Выбор существующего пользовательского поля лида
    $("#leadUserFieldsList").on("click", ".userField",function(){
      $("#leadUserFieldsList").find(".userField").each(function(){$(this).css("border","1px solid white");});
      $('#leadFieldMandatory').prop('checked', false);
      $('#leadFieldMultiple').prop('checked', false);
      $(this).css("border","1px solid black");
      $("#addLeadUserField").html("Сохранить");
      $("#leadFieldId").val($(this).attr("fieldid"));
      $("#leadFieldName").val($(this).attr("fieldname").replace('UF_CRM_',''));
      $("#leadFieldName").prop("readonly", true);
      $("#leadFieldLabel").val($(this).attr("fieldlabel"));
      if ($(this).attr("fieldmandatory") == "Y") $('#leadFieldMandatory').prop('checked', true);
      if ($(this).attr("fieldmultiple") == "Y") $('#leadFieldMultiple').prop('checked', true);
      $("#leadFieldType").val($(this).attr("usertypeid"));
      $("#deleteLeadUserField").removeClass("disabled");
    });
    //Выбор существующего пользовательского поля сделки
    $("#dealUserFieldsList").on("click", ".userField",function(){
      $("#dealUserFieldsList").find(".userField").each(function(){$(this).css("border","1px solid white");});
      $('#dealFieldMandatory').prop('checked', false);
      $('#dealFieldMultiple').prop('checked', false);
      $("#addDealUserField").html("Сохранить");
      $(this).css("border","1px solid black");
      $("#dealFieldId").val($(this).attr("fieldid"));
      $("#dealFieldName").val($(this).attr("fieldname").replace('UF_CRM_',''));
      $("#dealFieldName").prop("readonly", true);
      $("#dealFieldLabel").val($(this).attr("fieldlabel"));
      if ($(this).attr("fieldmandatory") == "Y") $('#dealFieldMandatory').prop('checked', true);
      if ($(this).attr("fieldmultiple") == "Y") $('#dealFieldMultiple').prop('checked', true);
      $("#dealFieldType").val($(this).attr("usertypeid"));
      $("#deleteDealUserField").removeClass("disabled");
    });
    //Очистить форму пользовательского поля лида
    $("#clearLeadUserField").on("click", function(){
      clearLeadUserFieldForm();
    })
    //Очистить форму пользовательского поля сделки
    $("#clearDealUserField").on("click", function(){
      clearDealUserFieldForm();
    })
    //Сохранить пользовательское поле лида
    $("#addLeadUserField").on("click", function(){
      var leadId = $("#leadFieldId").val();
      var leadFields ={
        "FIELD_NAME": $("#leadFieldName").val(),
        "EDIT_FORM_LABEL": $("#leadFieldLabel").val(),
        "LIST_COLUMN_LABEL": $("#leadFieldLabel").val(),
        "MANDATORY" : $('#leadFieldMandatory').prop('checked') ? "Y":"N",
        "MULTIPLE" : $('#leadFieldMultiple').prop('checked') ? "Y":"N",
        "USER_TYPE_ID": $("#leadFieldType").val(),
      };
      if (leadId.length >0){//Обновляем существующее поле
        BX24.callMethod(
          "crm.lead.userfield.update",
          {
            id: leadId,
            fields: leadFields
          },
          function(result){
            var s = '';
            s += '<b>' + result.query.method + '</b>\n';
            s += JSON.stringify(result.query.data, null, '  ') + '\n\n';
            if(result.error()){
              s += '<span style="color: red">Error! ' + result.error().getStatus() + ': ' + result.error().toString() + '</span>\n';
              $("#messages").html(s);
            }else{
              clearLeadUserFieldForm();
              clearLeadUserFieldsList();
              loadLeadUserFieldsList();
              $("#messages").html("Поле сохранено!!!");
            }
          }
        );
      }else{//Создаем новое поле
        BX24.callMethod(
          "crm.lead.userfield.add",
          {
            fields: leadFields
          },
          function(result){
            var s = '';
            s += '<b>' + result.query.method + '</b>\n';
            s += JSON.stringify(result.query.data, null, '  ') + '\n\n';
            if(result.error()){
              s += '<span style="color: red">Error! ' + result.error().getStatus() + ': ' + result.error().toString() + '</span>\n';
              $("#messages").html(s);
            }else{
              clearLeadUserFieldForm();
              clearLeadUserFieldsList();
              loadLeadUserFieldsList();
              $("#messages").html("Поле добавлено!!!");
            }
          }
        );
      }
    });
    //Сохранить пользовательское поле сделки
    $("#addDealUserField").on("click", function(){
      var dealId = $("#dealFieldId").val();
      var dealFields ={
        "FIELD_NAME": $("#dealFieldName").val(),
        "EDIT_FORM_LABEL": $("#dealFieldLabel").val(),
        "LIST_COLUMN_LABEL": $("#dealFieldLabel").val(),
        "MANDATORY" : $('#dealFieldMandatory').prop('checked') ? "Y":"N",
        "MULTIPLE" : $('#dealFieldMultiple').prop('checked') ? "Y":"N",
        "USER_TYPE_ID": $("#dealFieldType").val(),
      };
      if (dealId.length >0){//Обновляем существующее поле
        BX24.callMethod(
          "crm.deal.userfield.update",
          {
            id: dealId,
            fields: dealFields
          },
          function(result){
            var s = '';
            s += '<b>' + result.query.method + '</b>\n';
            s += JSON.stringify(result.query.data, null, '  ') + '\n\n';
            if(result.error()){
              s += '<span style="color: red">Error! ' + result.error().getStatus() + ': ' + result.error().toString() + '</span>\n';
              $("#messages").html(s);
            }else{
              clearDealUserFieldForm();
              clearDealUserFieldsList();
              loadDealUserFieldsList();
              $("#messages").html("Поле сохранено!!!");
            }
          }
        );        
      }else{//Создаем новое поле
        BX24.callMethod(
          "crm.deal.userfield.add",
          {
            fields: dealFields
          },
          function(result){
            var s = '';
            s += '<b>' + result.query.method + '</b>\n';
            s += JSON.stringify(result.query.data, null, '  ') + '\n\n';
            if(result.error()){
              s += '<span style="color: red">Error! ' + result.error().getStatus() + ': ' + result.error().toString() + '</span>\n';
              $("#messages").html(s);
            }else{
              clearDealUserFieldForm();
              clearDealUserFieldsList();
              loadDealUserFieldsList();
              $("#messages").html("Поле добавлено!!!");
            }
          }
        );        
      }
    });
    //Удалить пользовательское поле лида
    $("#deleteLeadUserField").on("click", function(){
      var leadId = $("#leadFieldId").val();
      if (leadId.length >0){//Если есть выбраное поле
        var yes2Delete = confirm("Вы действительно хотите удалить поле '"+$("#leadFieldLabel").val()+"'?");
        if (yes2Delete){
          BX24.callMethod(
            "crm.lead.userfield.delete",
            {
              id: leadId
            },
            function(result){
              var s = '';
              s += '<b>' + result.query.method + '</b>\n';
              s += JSON.stringify(result.query.data, null, '  ') + '\n\n';
              if(result.error()){
                s += '<span style="color: red">Error! ' + result.error().getStatus() + ': ' + result.error().toString() + '</span>\n';
                $("#messages").html(s);
              }else{
                clearLeadUserFieldForm();
                clearLeadUserFieldsList();
                loadLeadUserFieldsList();
                $("#messages").html("Поле удалено!!!");
              }
            }
          ); 
        }
      }
    });
    //Удалить пользовательское поле сделки
    $("#deleteDealUserField").on("click", function(){
      var dealId = $("#dealFieldId").val();
      if (dealId.length >0){//Если есть выбраное поле
        var yes2Delete = confirm("Вы действительно хотите удалить поле '"+$("#dealFieldLabel").val()+"'?");
        if (yes2Delete){
          BX24.callMethod(
            "crm.deal.userfield.delete",
            {
              id: dealId
            },
            function(result){
              var s = '';
              s += '<b>' + result.query.method + '</b>\n';
              s += JSON.stringify(result.query.data, null, '  ') + '\n\n';
              if(result.error()){
                s += '<span style="color: red">Error! ' + result.error().getStatus() + ': ' + result.error().toString() + '</span>\n';
                $("#messages").html(s);
              }else{
                clearDealUserFieldForm();
                clearDealUserFieldsList();
                loadDealUserFieldsList();
                $("#messages").html("Поле удалено!!!");
              }
            }
          ); 
        }
      }      
    });
  })
});