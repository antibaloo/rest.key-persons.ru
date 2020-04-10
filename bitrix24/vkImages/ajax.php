<?
if(isset($_POST['my_file_upload'])){  
  // VK API-Урок загрузка фото в альбом группы через PHP и CURL
  // Только STANDALONE TOKEN
  $token = 'c2dfbf0305fed1569e924ef59d6013c6a0342354951f94ff11340d5d34629e9dbee4fb64ac5203b138719';
  
  $group_id = '165717491';
  $album_id = '253742127';
  $v = '5.101'; //версия vk api
  
  // ВАЖНО! тут должны быть все проверки безопасности передавемых файлов и вывести ошибки если нужно
	$uploaddir = './uploads'; // . - текущая папка где находится submit.php

	// cоздадим папку если её нет
	if(! is_dir($uploaddir)) mkdir($uploaddir, 0777);

	$files      = $_FILES; // полученные файлы
	$done_files = array();
  $post_data = array();
	// переместим файлы из временной директории в указанную
	foreach($files as $key=>$file){
		$file_name = $file['name'];
    

		if(move_uploaded_file( $file['tmp_name'], "$uploaddir/$file_name")){
			$done_files[] = realpath("$uploaddir/$file_name");
      //$index = "file".strval($key+1);
      $post_data[] = new CurlFile(realpath("$uploaddir/$file_name"));//Данные для отправки файлов в вк
		}
	}
  
  
  // получаем урл для загрузки
  $url = file_get_contents("https://api.vk.com/method/photos.getUploadServer?album_id=".$album_id."&group_id=".$group_id."&v=".$v."&access_token=".$token);
  $url = json_decode($url)->response->upload_url;
  
  //Формируем пакеты по 5 фотографий (ограничение vk api)
  $post_data = array_chunk($post_data, 5);
  foreach($post_data as $key=>$element){
    foreach($element as $subKey=>$subElement){
      $post_data[$key]["file".strval($subKey+1)] = $subElement;
      unset($post_data[$key][$subKey]);
    }
  }
  $links = array();
  foreach ($post_data as $pack){
    // отправка post картинки
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS,  $pack);
    $result = json_decode(curl_exec($ch),true);
    
    // сохраняем
    $save  = file_get_contents("https://api.vk.com/method/photos.save?server=".$result['server']."&photos_list=".$result['photos_list']."&album_id=".$result['aid']."&hash=".$result['hash']."&group_id=".$group_id."&access_token=".$token."&v=".$v);
    $save = json_decode($save,true);
    
    //сохраняем ссылки на оригинальные картинки
    foreach($save['response'] as $vkFile){//Перебор всех загруженных на VK файлов
      $picUrl = "";
      $width = 0;
      foreach ($vkFile['sizes'] as $size){//Перебор всех размеров загруженног на VK файла
        if ($size['width'] > $width){
          $width = $size['width'];
          $picUrl = $size['url'];
        }
      }
      $links[] = $picUrl;
    }
  }
  //Удаляем загруженые файлы с сервера
  if (count($links) > 0){
    foreach($done_files as $key=>$file){
      unlink($file);
    }
    
  }
	$data = $links ? array('files' => $links ) : array('error' => 'Ошибка загрузки файлов.');
  $data['vk'] = $save['response'];
  $data['postVk'] = $post_data;
  $data['result'] = $result;
	die(json_encode($data));
}
?>