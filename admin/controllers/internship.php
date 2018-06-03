<?php
Class Controller_Internship Extends Controller_Base 
{
    protected function _initTemplate($title)
    {
        //єто файл templates/index.phtml
        return parent::_initTemplate($title);
    }
    
    public function index() 
    {
        $template = $this->_initTemplate('Стажування');
        
        $template->setFile('templates/internship.phtml');
        
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
// Узнаем количество всех доступных записей 
        $result = mysqli_query($db, "   SELECT * FROM internship");
        
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
        $result1 = mysqli_query($db, "SELECT * FROM internship ORDER BY id DESC LIMIT $quantity OFFSET $list;");

//код для редагування статті
        $id = isset($_GET['id']) ? $_GET['id'] : 0; 


        $res = mysqli_query($db, "   SELECT * FROM internship WHERE id='$id'");


        $roww = mysqli_fetch_array($res);
        $template->set('roww', $roww);

        if (isset($_POST['save'])) {
            $title = strip_tags(trim($_POST['title']));
            $text = quotemeta($_POST['text']);
            $author = strip_tags(trim($_POST['author']));

            mysqli_query($db, "UPDATE internship SET title='$title', text='$text', author='$author' WHERE id='$id'");

            header("Location: /admin/internship");
            exit();
        }

//видалення статті
        if (isset($_GET['delete'])) {
            $delete = mysqli_query($db, "DELETE FROM `internship` WHERE id='$id'");
            $template->set('delete', $delete);
        }

        mysqli_close($db);
        $template->set('result1', $result1);
// Считаем количество полученных записей
        $num_result = mysqli_num_rows($result1);
        $template->set('num_result', $num_result);

        $this->_renderLayout($template);
    }
}