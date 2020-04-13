BX24.ready(function(){
  BX24.init(function(){
    //Загрузка списка типов пользовательских полей
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
          result.data().forEach(function(item){
            $('#leadFieldType').append('<option value="'+item.ID+'">'+item.title+'</option>');
            $('#dealFieldType').append('<option value="'+item.ID+'">'+item.title+'</option>');
          });
        }
      }
    );
    //Загрузка списка пользовательских полей в лидах
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
    //Загрузка списка пользовательских полей в сделках
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
    //Выбор существующего пользовательского поля лида
    $("#leadUserFieldsList").on("click", ".userField",function(){
      $("#leadUserFieldsList").find(".userField").each(function(){$(this).css("border","1px solid white");});
      $('#leadFieldMandatory').prop('checked', false);
      $('#leadFieldMultiple').prop('checked', false);
      $(this).css("border","1px solid black");
      $("#addLeadUserField").html("Сохранить");
      $("#leadFieldId").val($(this).attr("fieldid"));
      $("#leadFieldName").val($(this).attr("fieldname"));
      $("#leadFieldLabel").val($(this).attr("fieldlabel"));
      if ($(this).attr("fieldmandatory") == "Y") $('#leadFieldMandatory').prop('checked', true);
      if ($(this).attr("fieldmultiple") == "Y") $('#leadFieldMultiple').prop('checked', true);
      $("#leadFieldType").val($(this).attr("usertypeid"));
    });
    //Выбор существующего пользовательского поля сделки
    $("#dealUserFieldsList").on("click", ".userField",function(){
      $("#dealUserFieldsList").find(".userField").each(function(){$(this).css("border","1px solid white");});
      $('#dealFieldMandatory').prop('checked', false);
      $('#dealFieldMultiple').prop('checked', false);
      $("#addDealUserField").html("Сохранить");
      $(this).css("border","1px solid black");
      $("#dealFieldId").val($(this).attr("fieldid"));
      $("#dealFieldName").val($(this).attr("fieldname"));
      $("#dealFieldLabel").val($(this).attr("fieldlabel"));
      if ($(this).attr("fieldmandatory") == "Y") $('#dealFieldMandatory').prop('checked', true);
      if ($(this).attr("fieldmultiple") == "Y") $('#dealFieldMultiple').prop('checked', true);
      $("#dealFieldType").val($(this).attr("usertypeid"));
    });
    //Очистить форму пользовательского поля лида
    $("#clearLeadUserField").on("click", function(){
      $("#leadUserFieldsList").find(".userField").each(function(){$(this).css("border","1px solid white");});
      $("#leadFieldId").val("");
      $("#leadFieldName").val("");
      $("#leadFieldLabel").val("");
      $('#leadFieldMandatory').prop('checked', false);
      $('#leadFieldMultiple').prop('checked', false);
      $("#leadFieldType").val("");
      $("#addLeadUserField").html("Добавить");
    })
    //Очистить форму пользовательского поля сделки
    $("#clearDealUserField").on("click", function(){
      $("#dealUserFieldsList").find(".userField").each(function(){$(this).css("border","1px solid white");});
      $("#dealFieldId").val("");
      $("#dealFieldName").val("");
      $("#dealFieldLabel").val("");
      $('#dealFieldMandatory').prop('checked', false);
      $('#dealFieldMultiple').prop('checked', false);
      $("#dealFieldType").val("");
      $("#addDealUserField").html("Добавить");
    })
    //Сохранить пользовательское поле лида
    $("#addLeadUserField").on("click", function(){
      
    });
    //Сохранить пользовательское поле сделки
    $("#addDealUserField").on("click", function(){
      
    });
    //Загрузки списка пользовательских типов пользовательских полей
    BX24.callMethod(
      'userfieldtype.list', 
      {}, 
      function(result){
        console.log(result.data());
      }
    );
    
  })
});