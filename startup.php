<?php
    //подключаем автозагрузку классов
    include ( site_path .'classes/autoload.php' );
    //обьявляем клас для глобальных переменных
	$registry = new Registry;
	//устанавливаем соединение с базой данных
	require_once ( site_path .'config.php' );
	$db = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname );
	mysqli_set_charset ($db , 'utf8' );
	        if (!$db) {
            echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
            echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
	$registry->set ('db', $db);
?>
