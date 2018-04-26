<?php
    //подключаем автозагрузку классов
    include ( site_path .'classes/autoload.php' );
    //обьявляем клас для глобальных переменных
	$registry = new Registry;
	//устанавливаем соединение с базой данных
	require_once ( site_path .'config.php' );
	$db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname );
	mysqli_set_charset ($db , 'utf8' );
	$registry->set ('db', $db);
?>
