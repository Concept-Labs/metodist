<?php
Class Controller_Metodrecommendations Extends Controller_Base 
{
    protected function _initTemplate($title)
    {
        //єто файл templates/index.phtml
        return parent::_initTemplate($title);
    }
    
    public function index() 
    {
        $template = $this->_initTemplate('Методичні рекомендації');
        
        //$template->set("data", "Hello", false);
        //$template->set("name", "Vitalik", false);
        $template->setFile('templates/metodrecommendations.phtml');
        
        $db = $this->_registry->get('db');
// Устанавливаем количество записей, которые будут выводиться на одной странице
// Поставьте нужное вам число. Для примера я указал одну запись на страницу
        $quantity=10;
        $template->set('quantity', $quantity);
// Если значение page= не является числом, то показываем
// пользователю первую страницу
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        if(!is_numeric($page)) $page=1;

// Если пользователь вручную поменяет в адресной строке значение page= на нуль,
// то мы определим это и поменяем на единицу, то-есть отправим на первую
// страницу, чтобы избежать ошибки
        if ($page<1) {
            $page=1;
            header("Location: /metodrecommendations/teacher?page=1");
            exit();
        }
// Достаєм всі елементи із таблиці teacher і поміщаємо в таблицю metodrecommendations
        $result1 = mysqli_query($db, "   SELECT id, title, text, date, time, author FROM teacher");

        while ($row1 = mysqli_fetch_array($result1)) {
            $title1 = $row1['title'];
            
            $resultat1 = mysqli_query($db, "   SELECT id, title, text, date, time, author FROM metodrecommendations WHERE title='$title1'");

            $myrow1 = mysqli_fetch_array($resultat1);
            
            if (empty($myrow1['id'])) {                    
                $sql1 = mysqli_query($db, "INSERT INTO `metodrecommendations` (`id`, `title`, `text`, `date`, `time`, `author`) VALUES (null, '{$row1['title']}', '{$row1['text']}', '{$row1['date']}', '{$row1['time']}', '{$row1['author']}')");
            }
        }

// Достаєм всі елементи із таблиці master і поміщаємо в таблицю metodrecommendations
        $result2 = mysqli_query($db, "   SELECT id, title, text, date, time, author FROM master");

        while ($row2 = mysqli_fetch_array($result2)) {
            $title2 = $row2['title'];
            
            $resultat2 = mysqli_query($db, "   SELECT id, title, text, date, time, author FROM metodrecommendations WHERE title='$title2'");

            $myrow2 = mysqli_fetch_array($resultat2);
            
            if (empty($myrow2['id'])) {                    
                $sql2 = mysqli_query($db, "INSERT INTO `metodrecommendations` (`id`, `title`, `text`, `date`, `time`, `author`) VALUES (null, '{$row2['title']}', '{$row2['text']}', '{$row2['date']}', '{$row2['time']}', '{$row2['author']}')");
            }
        }

// Достаєм всі елементи із таблиці chairman_mk і поміщаємо в таблицю metodrecommendations
        $result3 = mysqli_query($db, "   SELECT id, title, text, date, time, author FROM chairman_mk");

        while ($row3 = mysqli_fetch_array($result3)) {
            $title3 = $row3['title'];
            
            $resultat3 = mysqli_query($db, "   SELECT id, title, text, date, time, author FROM metodrecommendations WHERE title='$title3'");

            $myrow3 = mysqli_fetch_array($resultat3);
            
            if (empty($myrow3['id'])) {                    
                $sql3 = mysqli_query($db, "INSERT INTO `metodrecommendations` (`id`, `title`, `text`, `date`, `time`, `author`) VALUES (null, '{$row3['title']}', '{$row3['text']}', '{$row3['date']}', '{$row3['time']}', '{$row3['author']}')");
            }
        }

// Достаєм всі елементи із таблиці young_teacher і поміщаємо в таблицю metodrecommendations
        $result4 = mysqli_query($db, "   SELECT id, title, text, date, time, author FROM young_teacher");

        while ($row4 = mysqli_fetch_array($result4)) {
            $title4 = $row4['title'];
            
            $resultat4 = mysqli_query($db, "   SELECT id, title, text, date, time, author FROM metodrecommendations WHERE title='$title4'");

            $myrow4 = mysqli_fetch_array($resultat4);
            
            if (empty($myrow4['id'])) {                    
                $sql4 = mysqli_query($db, "INSERT INTO `metodrecommendations` (`id`, `title`, `text`, `date`, `time`, `author`) VALUES (null, '{$row4['title']}', '{$row4['text']}', '{$row4['date']}', '{$row4['time']}', '{$row4['author']}')");
            }
        }

// Достаєм всі елементи із таблиці class_teacher і поміщаємо в таблицю metodrecommendations
        $result5 = mysqli_query($db, "   SELECT id, title, text, date, time, author FROM class_teacher");

        while ($row5 = mysqli_fetch_array($result5)) {
            $title5 = $row5['title'];
            
            $resultat5 = mysqli_query($db, "   SELECT id, title, text, date, time, author FROM metodrecommendations WHERE title='$title5'");

            $myrow5 = mysqli_fetch_array($resultat5);
            
            if (empty($myrow5['id'])) {                    
                $sql5 = mysqli_query($db, "INSERT INTO `metodrecommendations` (`id`, `title`, `text`, `date`, `time`, `author`) VALUES (null, '{$row5['title']}', '{$row5['text']}', '{$row5['date']}', '{$row5['time']}', '{$row5['author']}')");
            }
        }

        $resultat = mysqli_query($db, "   SELECT id, title, text, date, time, author FROM metodrecommendations");

// Узнаем количество всех доступных записей 
        $num = mysqli_num_rows($resultat);
        $template->set('num', $num);

// Вычисляем количество страниц, чтобы знать сколько ссылок выводить
        $pages = $num/$quantity;

// Округляем полученное число страниц в большую сторону
        $pages = ceil($pages);

// Здесь мы увеличиваем число страниц на единицу чтобы начальное значение было
// равно единице, а не нулю. Значение page= будет
// совпадать с цифрой в ссылке, которую будут видеть посетители
        $pages++; 

// Если значение page= больше числа страниц, то выводим первую страницу
        if ($page>$pages) $page = 1;

        $template->set('page', $page);
        $template->set('pages', $pages);
// Выводим заголовок с номером текущей страницы 


// Переменная $list указывает с какой записи начинать выводить данные.
// Если это число не определено, то будем выводить
// с самого начала, то-есть с нулевой записи
        if (!isset($list)) $list=0;

// Чтобы у нас значение page= в адресе ссылки совпадало с номером
// страницы мы будем его увеличивать на единицу при выводе ссылок, а
// здесь наоборот уменьшаем чтобы ничего не нарушить.
        $list=--$page*$quantity;

// Делаем запрос подставляя значения переменных $quantity и $list
        $result = mysqli_query($db, "SELECT id, title, text, date, time, author FROM metodrecommendations ORDER BY id DESC LIMIT $quantity OFFSET $list;"); 

            //код для виведення матеріалу а одну сторінку
        $id = isset($_GET['id']) ? $_GET['id'] : 0; 


        $res = mysqli_query($db, "   SELECT * FROM metodrecommendations WHERE id='$id'");


        $roww = mysqli_fetch_array($res);
        $template->set('roww', $roww); 

        mysqli_close($db);
        $template->set('result', $result);
// Считаем количество полученных записей
        $num_result = mysqli_num_rows($result);
        $template->set('num_result', $num_result);
        
        $this->_renderLayout($template);
    }
    
    public function teacher() 
    {
        $template = $this->_initTemplate('Рекомендації викладачу');
        $template->setFile('templates/metodrecommendations/teacher.phtml');
        
        $db = $this->_registry->get('db');
// Устанавливаем количество записей, которые будут выводиться на одной странице
// Поставьте нужное вам число. Для примера я указал одну запись на страницу
        $quantity=2;
        $template->set('quantity', $quantity);
// Если значение page= не является числом, то показываем
// пользователю первую страницу
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        if(!is_numeric($page)) $page=1;

// Если пользователь вручную поменяет в адресной строке значение page= на нуль,
// то мы определим это и поменяем на единицу, то-есть отправим на первую
// страницу, чтобы избежать ошибки
        if ($page<1) {
            $page=1;
            header("Location: /metodrecommendations/teacher?page=1");
            exit();
        }

// Узнаем количество всех доступных записей 
        $result = mysqli_query($db, "   SELECT id, title, text, date, time, author FROM teacher");
        
        $template->set('result', $result);
        $num = mysqli_num_rows($result);
        $template->set('num', $num);
// Вычисляем количество страниц, чтобы знать сколько ссылок выводить
        $pages = $num/$quantity;

// Округляем полученное число страниц в большую сторону
        $pages = ceil($pages);

// Здесь мы увеличиваем число страниц на единицу чтобы начальное значение было
// равно единице, а не нулю. Значение page= будет
// совпадать с цифрой в ссылке, которую будут видеть посетители
        $pages++; 

// Если значение page= больше числа страниц, то выводим первую страницу
        if ($page>$pages) $page = 1;

        $template->set('page', $page);
        $template->set('pages', $pages);
// Выводим заголовок с номером текущей страницы 

// Переменная $list указывает с какой записи начинать выводить данные.
// Если это число не определено, то будем выводить
// с самого начала, то-есть с нулевой записи
        if (!isset($list)) $list=0;

// Чтобы у нас значение page= в адресе ссылки совпадало с номером
// страницы мы будем его увеличивать на единицу при выводе ссылок, а
// здесь наоборот уменьшаем чтобы ничего не нарушить.
        $list=--$page*$quantity;

// Делаем запрос подставляя значения переменных $quantity и $list
        $result1 = mysqli_query($db, "SELECT id, title, text, date, time, author FROM teacher ORDER BY id DESC LIMIT $quantity OFFSET $list;");

            //код для виведення матеріалу а одну сторінку
        $id = isset($_GET['id']) ? $_GET['id'] : 0; 


        $res = mysqli_query($db, "   SELECT * FROM teacher WHERE id='$id'");


        $roww = mysqli_fetch_array($res);
        $template->set('roww', $roww);

        mysqli_close($db);
        $template->set('result1', $result1);
// Считаем количество полученных записей
        $num_result = mysqli_num_rows($result1);
        $template->set('num_result', $num_result);

        $this->_renderLayout($template);
    }
    
    public function master() 
    {
        $template = $this->_initTemplate('Рекомендації майстру в/н');
        $template->setFile('templates/metodrecommendations/master.phtml');

        $db = $this->_registry->get('db');
        // Устанавливаем количество записей, которые будут выводиться на одной странице
// Поставьте нужное вам число. Для примера я указал одну запись на страницу
        $quantity=10;
        $template->set('quantity', $quantity);
// Если значение page= не является числом, то показываем
// пользователю первую страницу
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        if(!is_numeric($page)) $page=1;

// Если пользователь вручную поменяет в адресной строке значение page= на нуль,
// то мы определим это и поменяем на единицу, то-есть отправим на первую
// страницу, чтобы избежать ошибки
        if ($page<1) {
            $page=1;
            header("Location: /metodrecommendations/master?page=1");
            exit();
        }

// Узнаем количество всех доступных записей 
        $result = mysqli_query($db, "   SELECT id, title, text, date, time, author FROM master");
        
        $template->set('result', $result);
        $num = mysqli_num_rows($result);
        $template->set('num', $num);

// Вычисляем количество страниц, чтобы знать сколько ссылок выводить
        $pages = $num/$quantity;

// Округляем полученное число страниц в большую сторону
        $pages = ceil($pages);

// Здесь мы увеличиваем число страниц на единицу чтобы начальное значение было
// равно единице, а не нулю. Значение page= будет
// совпадать с цифрой в ссылке, которую будут видеть посетители
        $pages++; 

// Если значение page= больше числа страниц, то выводим первую страницу
        if ($page>$pages) $page = 1;

        $template->set('page', $page);
        $template->set('pages', $pages);
// Выводим заголовок с номером текущей страницы 

// Переменная $list указывает с какой записи начинать выводить данные.
// Если это число не определено, то будем выводить
// с самого начала, то-есть с нулевой записи
        if (!isset($list)) $list=0;

// Чтобы у нас значение page= в адресе ссылки совпадало с номером
// страницы мы будем его увеличивать на единицу при выводе ссылок, а
// здесь наоборот уменьшаем чтобы ничего не нарушить.
        $list=--$page*$quantity;

// Делаем запрос подставляя значения переменных $quantity и $list
        $result1 = mysqli_query($db, "SELECT id, title, text, date, time, author FROM master ORDER BY id DESC LIMIT $quantity OFFSET $list;");

            //код для виведення матеріалу а одну сторінку
        $id = isset($_GET['id']) ? $_GET['id'] : 0; 


        $res = mysqli_query($db, "   SELECT * FROM master WHERE id='$id'");


        $roww = mysqli_fetch_array($res);
        $template->set('roww', $roww);

        mysqli_close($db);
        $template->set('result1', $result1);
// Считаем количество полученных записей
        $num_result = mysqli_num_rows($result1);
        $template->set('num_result', $num_result);

        $this->_renderLayout($template);
    }

    public function chairman_mk() 
    {
        $template = $this->_initTemplate('Рекомендації голові МК');
        $template->setFile('templates/metodrecommendations/chairman_mk.phtml');

        $db = $this->_registry->get('db');
        // Устанавливаем количество записей, которые будут выводиться на одной странице
// Поставьте нужное вам число. Для примера я указал одну запись на страницу
        $quantity=10;
        $template->set('quantity', $quantity);
// Если значение page= не является числом, то показываем
// пользователю первую страницу
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        if(!is_numeric($page)) $page=1;

// Если пользователь вручную поменяет в адресной строке значение page= на нуль,
// то мы определим это и поменяем на единицу, то-есть отправим на первую
// страницу, чтобы избежать ошибки
        if ($page<1) {
            $page=1;
            header("Location: /metodrecommendations/chairman_mk?page=1");
            exit();
        }

// Узнаем количество всех доступных записей 
        $result = mysqli_query($db, "   SELECT id, title, text, date, time, author FROM chairman_mk");
        
        $template->set('result', $result);
        $num = mysqli_num_rows($result);
        $template->set('num', $num);

// Вычисляем количество страниц, чтобы знать сколько ссылок выводить
        $pages = $num/$quantity;

// Округляем полученное число страниц в большую сторону
        $pages = ceil($pages);

// Здесь мы увеличиваем число страниц на единицу чтобы начальное значение было
// равно единице, а не нулю. Значение page= будет
// совпадать с цифрой в ссылке, которую будут видеть посетители
        $pages++; 

// Если значение page= больше числа страниц, то выводим первую страницу
        if ($page>$pages) $page = 1;

        $template->set('page', $page);
        $template->set('pages', $pages);
// Выводим заголовок с номером текущей страницы 


// Переменная $list указывает с какой записи начинать выводить данные.
// Если это число не определено, то будем выводить
// с самого начала, то-есть с нулевой записи
        if (!isset($list)) $list=0;

// Чтобы у нас значение page= в адресе ссылки совпадало с номером
// страницы мы будем его увеличивать на единицу при выводе ссылок, а
// здесь наоборот уменьшаем чтобы ничего не нарушить.
        $list=--$page*$quantity;

// Делаем запрос подставляя значения переменных $quantity и $list
        $result1 = mysqli_query($db, "SELECT id, title, text, date, time, author FROM chairman_mk ORDER BY id DESC LIMIT $quantity OFFSET $list;");

            //код для виведення матеріалу а одну сторінку
        $id = isset($_GET['id']) ? $_GET['id'] : 0; 


        $res = mysqli_query($db, "   SELECT * FROM chairman_mk WHERE id='$id'");


        $roww = mysqli_fetch_array($res);
        $template->set('roww', $roww);

        mysqli_close($db);
        $template->set('result1', $result1);
// Считаем количество полученных записей
        $num_result = mysqli_num_rows($result1);
        $template->set('num_result', $num_result);

        $this->_renderLayout($template);
    }

    public function young_teacher() 
    {
        $template = $this->_initTemplate('Рекомендації молодому педагогу');
        $template->setFile('templates/metodrecommendations/young_teacher.phtml');

        $db = $this->_registry->get('db');
        // Устанавливаем количество записей, которые будут выводиться на одной странице
// Поставьте нужное вам число. Для примера я указал одну запись на страницу
        $quantity=10;
        $template->set('quantity', $quantity);
// Если значение page= не является числом, то показываем
// пользователю первую страницу
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        if(!is_numeric($page)) $page=1;

// Если пользователь вручную поменяет в адресной строке значение page= на нуль,
// то мы определим это и поменяем на единицу, то-есть отправим на первую
// страницу, чтобы избежать ошибки
        if ($page<1) {
            $page=1;
            header("Location: /metodrecommendations/young_teacher?page=1");
            exit();
        }
// Узнаем количество всех доступных записей 
        $result = mysqli_query($db, "   SELECT id, title, text, date, time, author FROM young_teacher");
        
        $template->set('result', $result);
        $num = mysqli_num_rows($result);
        $template->set('num', $num);

// Вычисляем количество страниц, чтобы знать сколько ссылок выводить
        $pages = $num/$quantity;

// Округляем полученное число страниц в большую сторону
        $pages = ceil($pages);

// Здесь мы увеличиваем число страниц на единицу чтобы начальное значение было
// равно единице, а не нулю. Значение page= будет
// совпадать с цифрой в ссылке, которую будут видеть посетители
        $pages++; 

// Если значение page= больше числа страниц, то выводим первую страницу
        if ($page>$pages) $page = 1;

        $template->set('page', $page);
        $template->set('pages', $pages);
// Выводим заголовок с номером текущей страницы 


// Переменная $list указывает с какой записи начинать выводить данные.
// Если это число не определено, то будем выводить
// с самого начала, то-есть с нулевой записи
        if (!isset($list)) $list=0;

// Чтобы у нас значение page= в адресе ссылки совпадало с номером
// страницы мы будем его увеличивать на единицу при выводе ссылок, а
// здесь наоборот уменьшаем чтобы ничего не нарушить.
        $list=--$page*$quantity;

// Делаем запрос подставляя значения переменных $quantity и $list
        $result1 = mysqli_query($db, "SELECT id, title, text, date, time, author FROM young_teacher ORDER BY id DESC LIMIT $quantity OFFSET $list;");

            //код для виведення матеріалу а одну сторінку
        $id = isset($_GET['id']) ? $_GET['id'] : 0; 


        $res = mysqli_query($db, "   SELECT * FROM young_teacher WHERE id='$id'");


        $roww = mysqli_fetch_array($res);
        $template->set('roww', $roww);

        mysqli_close($db);
        $template->set('result1', $result1);
// Считаем количество полученных записей
        $num_result = mysqli_num_rows($result1);
        $template->set('num_result', $num_result);

        $this->_renderLayout($template);
    }

    public function class_teacher() 
    {
        $template = $this->_initTemplate('Рекомендації класному керівнику');
        $template->setFile('templates/metodrecommendations/class_teacher.phtml');

        $db = $this->_registry->get('db');
        // Устанавливаем количество записей, которые будут выводиться на одной странице
// Поставьте нужное вам число. Для примера я указал одну запись на страницу
        $quantity=10;
        $template->set('quantity', $quantity);
// Если значение page= не является числом, то показываем
// пользователю первую страницу
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        if(!is_numeric($page)) $page=1;

// Если пользователь вручную поменяет в адресной строке значение page= на нуль,
// то мы определим это и поменяем на единицу, то-есть отправим на первую
// страницу, чтобы избежать ошибки
        if ($page<1) {
            $page=1;
            header("Location: /metodrecommendations/class_teacher?page=1");
            exit();
        }
// Узнаем количество всех доступных записей 
        $result = mysqli_query($db, "   SELECT id, title, text, date, time, author FROM class_teacher");
        
        $template->set('result', $result);
        $num = mysqli_num_rows($result);
        $template->set('num', $num);

// Вычисляем количество страниц, чтобы знать сколько ссылок выводить
        $pages = $num/$quantity;

// Округляем полученное число страниц в большую сторону
        $pages = ceil($pages);

// Здесь мы увеличиваем число страниц на единицу чтобы начальное значение было
// равно единице, а не нулю. Значение page= будет
// совпадать с цифрой в ссылке, которую будут видеть посетители
        $pages++; 

// Если значение page= больше числа страниц, то выводим первую страницу
        if ($page>$pages) $page = 1;

        $template->set('page', $page);
        $template->set('pages', $pages);
// Выводим заголовок с номером текущей страницы 


// Переменная $list указывает с какой записи начинать выводить данные.
// Если это число не определено, то будем выводить
// с самого начала, то-есть с нулевой записи
        if (!isset($list)) $list=0;

// Чтобы у нас значение page= в адресе ссылки совпадало с номером
// страницы мы будем его увеличивать на единицу при выводе ссылок, а
// здесь наоборот уменьшаем чтобы ничего не нарушить.
        $list=--$page*$quantity;

// Делаем запрос подставляя значения переменных $quantity и $list
        $result1 = mysqli_query($db, "SELECT id, title, text, date, time, author FROM class_teacher ORDER BY id DESC LIMIT $quantity OFFSET $list;");

            //код для виведення матеріалу а одну сторінку
        $id = isset($_GET['id']) ? $_GET['id'] : 0; 


        $res = mysqli_query($db, "   SELECT * FROM class_teacher WHERE id='$id'");


        $roww = mysqli_fetch_array($res);
        $template->set('roww', $roww);

        mysqli_close($db);
        $template->set('result1', $result1);
// Считаем количество полученных записей
        $num_result = mysqli_num_rows($result1);
        $template->set('num_result', $num_result);

        $this->_renderLayout($template);
    }
}
