<?
session_start();

date_default_timezone_set("Europe/Moscow"); 

$host = "localhost";
$user_name = "root";
$password = "pass";
$db_name = "test";

$perpage = 3; //количество отображаемых постов

if (!$conn = mysql_connect($host, $user_name, $password)) {
echo 'MySQL Error!';
exit;
}

mysql_select_db($db_name);

if (isset($_POST['name']) and isset($_POST['text']) and isset($_POST['captcha'])) {
  if ($_POST['name'] and $_POST['text'] and $_POST['captcha']) {
    if ($_POST['captcha']==$_SESSION['secpic']) {
      $result = mysql_query("INSERT INTO `$db_name`.`guest` (`id`, `name`, `data`, `text`) VALUES (NULL, '".$_POST['name']."', '".time()."', '".urlencode($_POST['text'])."');");
 
      if ($result==true) {
        echo "Ваши данные успешно добавлены";
      } else echo "Запись не добавлена";
    } else echo 'Неверная капча!';
  } else echo 'Необходимо заполнить все поля!';
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html lang="en">
<head>
	<title>Татарский государственный театр драмы и комедии им. Карима Тинчурина</title>
    <link rel="stylesheet" href="../nivo-slider.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="../style2.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="../news.css" type="text/css" media="screen" />

<script type="text/javascript" src="jquery-1.4.2.min.js"></script>
<script>
function facechange (objName) {
  if ( $(objName).css('display') == 'none' ) {
    $(objName).animate({height: 'show'}, 400);
  } else {
    $(objName).animate({height: 'hide'}, 200);
  }
}
</script>

</head>
<body>

<div id="lang">
<a href=""><div id="rus"></div></a>
<a href=""><div id="tat"></div></a>
<a href=""><div id="eng"></div></a>
</div>

<a href="../">
<div id="logo">
<div id="logo-1"></div>
<div id="logo-2"></div>
</div>
</a>

<div id="menu">
<ul>
<a href="../afisha" class="menu"><li class="menuli first">Афиша</li></a>
<a href="../about" class="menu"><li class="menuli">О театре</li></a>
<a href="../repertoire" class="menu"><li class="menuli">Репертуар</li></a>
<a href="../team" class="menu"><li class="menuli">Коллектив</li></a>
<a href="../guest" class="menu"><li class="menuli">Гостевая</li></a>
</ul>
</div>


<div id="main-out">
<div id="main">

<div id="forme">
 <form method="post">
  <input type="text" name="name" placeholder="Ваше имя.."><br>
  <img src="secpic.php" /><br>
  <input type="text" name="captcha"><br><br>
  <textarea name="text"></textarea><br><br>
  <p><input type="submit"></p>
 </form>
 </div>



<?php

function link_bar($page, $pages_count) {
  for ($j = 1; $j <= $pages_count; $j++) {
    if ($j == $page) {
      echo ' <a><b>'.$j.'</b></a> ';
    } else {
      echo ' <a href='.$_SERVER['php_self'].'?page='.$j.'>'.$j.'</a> ';
    }
    if ($j != $pages_count) echo ' ';
  }
  return true;
}

if (empty($_GET['page']) || ($_GET['page'] <= 0)) {
  $page = 1;
} else {
  $page = (int) $_GET['page'];
}

$count = mysql_num_rows(mysql_query('select * from `guest` ORDER BY  `guest`.`id` DESC ')) or die('error! Записей не найдено!');
$pages_count = ceil($count / $perpage);
if ($page > $pages_count) $page = $pages_count;
$start_pos = ($page - 1) * $perpage;



$result = mysql_query('select * from `guest` ORDER BY  `guest`.`id` DESC  limit '.$start_pos.', '.$perpage) or die('error!');
while ($row = mysql_fetch_array($result)) { ?>
<div id="com">
<h3><? echo $row['name']; ?></h3>
<h4><? echo date("m.d.Y H:i", $row['data']); ?></h4>
<p><? echo urldecode($row['text']); ?></p>
</div>
<? 
} 
link_bar($page, $pages_count);
?>

</div>
</div>


     <div id="footer">
     <div id="foot-left">
     <a href="">Пресса о нас</a><br>
     Телефон: <b>+7 (927) 296 56 78</b><br>
     Адрес: <b>420015, Казан, М.Горький ур, 13.</b>
     </div>
     <div id="vk" onClick="window.location='http://vk.com/tinchurinteatr'" style="cursor:pointer"></div>
     </div>



</body>
</html>