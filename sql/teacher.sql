-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 26 2018 г., 18:24
-- Версия сервера: 10.1.30-MariaDB
-- Версия PHP: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `metodist`
--

-- --------------------------------------------------------

--
-- Структура таблицы `teacher`
--

CREATE TABLE `teacher` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `image` varchar(100) DEFAULT 'default.jpg',
  `date` date NOT NULL,
  `time` time NOT NULL,
  `author` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `teacher`
--

INSERT INTO `teacher` (`id`, `title`, `text`, `image`, `date`, `time`, `author`) VALUES
(1, 'Робота з уроками', 'Первый раздел кода весьма простой - мы устанавливаем обычное горизонтальное меню. Но, обратите внимание, что селекторы #nav li и #nav li a выделяют все элементы списка и ссылки в выпадающих пунктах тоже. Использование каскадов.\r\n\r\nСледует отметить использование  position:relative; для элементов списка. Таким образом, мы сможем использовать  position:absolute; для вложенных элементов <ul>.\r\nВ данном коде устанавливаются стили для вложенных <ul> в пункт верхнего уровня. Очевидно, что нужно удалить метки пунктов списка с помощью  list-style:none;, и установить position:absolute; для позиционирования выпадающих подпунктов под пунктом списка, который их содержит.\r\n\r\nСледующая строка гораздо более интересна. Обычно используется свойство display:none; для того, чтобы скрыть выпадающий пункт, когда он не используется.  Но так как большинство программ для чтения с экрана игнорируют все, что имеет свойство display:none;, то использование такого метода очень нежелательно. Вместо этого мы используем абсолютное позиционирование <ul> для помещения его в позицию -9999px за пределами экрана, когда он не используется.\r\n\r\nЗатем следует свойство opacity:0;, для скрытия <ul>, и декларация для браузеров Webkit, для плавного вывода элемента <ul> при наведении курсора мыши.', 'default.jpg', '2018-04-26', '16:45:00', 'Віталій Булавін');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `teacher`
--
ALTER TABLE `teacher`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `teacher`
--
ALTER TABLE `teacher`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
