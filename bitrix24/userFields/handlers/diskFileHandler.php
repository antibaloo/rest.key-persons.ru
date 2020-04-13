<?
$placement = $_REQUEST['PLACEMENT'];
$placementOptions = isset($_REQUEST['PLACEMENT_OPTIONS']) ? json_decode($_REQUEST['PLACEMENT_OPTIONS'], true) : array();
$handler = ($_SERVER['SERVER_PORT'] === '443' ? 'https' : 'http').'://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'];
?>
<!DOCTYPE html>
<html>
<head>
	<script src="//api.bitrix24.com/api/v1/dev/"></script>
</head>
<body style="margin: 0; padding: 0; background-color: <?=$placementOptions['MODE'] === 'edit' ? '#fff' : '#f9fafb'?>;">
  <div class="workarea">
<?
if($placement === 'DEFAULT')://Запуск приложения настройки поля
?>
<?
elseif($placement === 'USERFIELD_TYPE')://Пользовательский тип
	if($placementOptions['MODE'] === 'edit') //Режим редактирования
	{
		if($placementOptions['MULTIPLE'] === 'N') //Поле не множественное
		{
?>
    <input type="text" style="width: 90%;" value="<?=htmlspecialchars($placementOptions['VALUE'])?>" onkeyup="setValue(this.value)">
    <script>
      function setValue(value){
        BX24.placement.call('setValue', value);
      }
    </script>
<?
		}
		else //Множественное поле
		{
?>
    <textarea style="width: 90%; height: 100px;" onkeyup="setValue(this.value)"><?=htmlspecialchars(implode("\n", $placementOptions['VALUE']))?></textarea>
    <script>
      function setValue(value){
        BX24.placement.call('setValue', value.split('\n'));
      }
    </script>
	<?
		}
	}
	else //Режим просмотра
	{

		if(is_array($placementOptions['VALUE']))//Множественное поле
		{
			foreach($placementOptions['VALUE'] as $value)
			{
				echo '<li>'.htmlspecialchars($value).'</li>';
			}
		}
		else //Не множественное поле
		{
			echo '<i>'.htmlspecialchars($placementOptions['VALUE']).'</i>';
		}

	}

endif;
?>
  </div>
  <script>
    BX24.ready(function(){
      BX24.init(function(){
        BX24.resizeWindow(document.body.clientWidth,document.getElementsByClassName("workarea")[0].clientHeight);
      })
    });
  </script>
  </body>
</html>
