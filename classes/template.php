<?php
Class Template 
{
    private $registry;
    private $vars = array();
    private $__file = null;
    private $__css = array();
    private $__js = array();
    
    public function __construct($registry) 
    {
        $this->registry = $registry;
    }

    public function set($varname, $value, $overwrite=false) 
    {
        if (isset($this->vars[$varname]) == true AND $overwrite == false) 
        {
            trigger_error ('Unable to set var `' . $varname . '`. Already set, and overwrite not allowed.',
                E_USER_NOTICE);
            return false;
        }
        $this->vars[$varname] = $value;
        return true;
    }

    public function get($varname)
    {
        return $this->vars[$varname];
    }

    public function remove($varname) 
    {
        unset($this->vars[$varname]);
        return true;
    }

    public function setFile($file)
    {
        $this->__file = $file;
        return $this;
    }

    public function toHtml()
    {
        if(!$this->__file){
            die('Темплейт должен иметь файл');
        }
        $fullPath = site_path . $this->__file;
        $content = file_get_contents($fullPath);
        
        $this->_addHeadFiles();
        if(preg_match_all( '/({{\$([A-Za-z]+)}})/mi', $content, $matches)){
            $replacer = $matches[1];
            $params = $matches[2];
            foreach($params as $i => $param){
                if(isset($this->vars[$param])){
                    $content = str_replace($replacer[$i], $this->vars[$param], $content);
                }
            }
        }
        return $content;
    }
    
    public function toHtmlWithPhp()
    {
        if(!$this->__file){
            die('Темплейт должен иметь файл');
        }
        ob_start();
        $includeFilePath = realpath(site_path . $this->__file);
        include $includeFilePath;
        $html = ob_get_clean();
        if(preg_match_all( '/({{\$([A-Za-z]+)}})/mi', $html, $matches)){
            $replacer = $matches[1];
            $params = $matches[2];
            foreach($params as $i => $param){
                if(isset($this->vars[$param])){
                    $html = str_replace($replacer[$i], $this->vars[$param], $html);
                }
            }
        }
        return $html;
    }
    
    public function addCss($file)
    {
        $this->__css[$file] = $file;
    }
    
    public function addJs($file)
    {
        $this->__js[$file] = $file;
    }
    
    public function _addHeadFiles()
    {
        $css = '';
        foreach($this->__css as $file){
            $css .= '<link rel="stylesheet" type="text/css" href="'.base_url . $file.'" media="all"/>';
        }
        $js = '';
        foreach($this->__js as $file){
            $js .= '<script type="text/javascript" src="'.base_url . $file.'"></script>';
        }
        $this->vars['headfiles'] = $css.' '.$js;
        return $this;
    }
    
    public function getUrl($url)
    {
        return base_url . $url;
    }

    function page_article_query($table, $part_url) 
{
    $db = $this->registry->get('db');
// Устанавливаем количество записей, которые будут выводиться на одной странице
// Поставьте нужное вам число. Для примера я указал одну запись на страницу
        $quantity=10;
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
        $result = mysqli_query($db, "   SELECT * FROM $table");

        $num = mysqli_num_rows($result);
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

// Выводим заголовок с номером текущей страницы 

// Переменная $list указывает с какой записи начинать выводить данные.
// Если это число не определено, то будем выводить
// с самого начала, то-есть с нулевой записи
        if (!isset($list)) $list=1;

// Чтобы у нас значение page= в адресе ссылки совпадало с номером
// страницы мы будем его увеличивать на единицу при выводе ссылок, а
// здесь наоборот уменьшаем чтобы ничего не нарушить.
// Делаем запрос подставляя значения переменных $quantity и $list
        $result1 = mysqli_query($db, "SELECT * FROM $table ORDER BY id DESC LIMIT $quantity");

            //код для виведення матеріалу а одну сторінку
        $id = isset($_GET['id']) ? $_GET['id'] : 0; 

        $res = mysqli_query($db, "   SELECT * FROM $table WHERE id='$id'");
        $roww = mysqli_fetch_array($res);

        mysqli_close($db);
// Считаем количество полученных записей
        $num_result = mysqli_num_rows($result1);
        ?>
<div class="content_left">
    <?php 

    if (!isset($_GET['articles'])) {
    // Ограничиваем количество ссылок, которые будут выводиться перед и
// после текущей страницы
        $limit=3;

        if ($num > $quantity) {
            echo '<strong style="color: #000; float:right; padding-right: 20px;">Сторінка № ' . $page .'</strong><br /><br />';
        }   

        if ($num_result) {    
            for ($i = 0; $i<$num_result; $i++) {
                while ($row = mysqli_fetch_array($result1)) {
                    ?>

                    <div class="sidebar2">
                        <h1><a href="<?php echo base_url .$part_url .'?articles&id='.$row['id']; ?>"><?php echo $row['title']."<br/>"; ?></a></h1>
                        <p><?php $text = $row['text'];
                        $counttext = 1000;
                        $text = substr($text, 0, $counttext);
                        $text = rtrim($text);
                        $text = substr($text, 0, strrpos($text, ' '));
                        if (mb_strlen($row['text']) > $counttext) {
                            echo $text; 
                            echo "<a href=".base_url .$part_url .'?articles&id='.$row['id']."> Читати далі . . .</a>";
                        } else {
                            echo $row['text'];
                        }   ?></p>  
                        <div class="bottom_sidebar">            
                            <i class="far fa-clock"></i> <?php echo $row['date'];?> / <?php echo $row['time']; ?>
                            <span class="author"><i class="fas fa-user-edit"></i><?php echo $row['author']."<br/>"; ?></span>
                            
                        </div>
                    </div>

                    <?php }     
                }
            } else echo "<div class='sidebar2'>На даний момент в цьому розділі немає матеріалу!</div>";
            if ($num > $quantity) {


        // Выводим ссылки "назад" и "на первую страницу"
                if ($page>=1) {

    // Значение page= для первой страницы всегда равно единице, 
    // поэтому так и пишем
                    echo '<span class="page_center"><a class="page" href="'.base_url .$part_url .'?page=1"><<</a> &nbsp; ';

    // Так как мы количество страниц до этого уменьшили на единицу, 
    // то для того, чтобы попасть на предыдущую страницу, 
    // нам не нужно ничего вычислять
                    echo '<a class="page" href="' .base_url .$part_url .'?page=' . ($page-1) . 
                    '">< </a> &nbsp; ';
                }

        // На данном этапе номер текущей страницы = $page+1
                $this1 = $page+1;

// Узнаем с какой ссылки начинать вывод
                $start = $this1-$limit;

// Узнаем номер последней ссылки для вывода
                $end = $this1+$limit;

// Выводим ссылки на все страницы
// Начальное число $j в нашем случае должно равнятся единице, а не нулю
                for ($j = 1; $j<$pages; $j++) {

    // Выводим ссылки только в том случае, если их номер больше или равен
    // начальному значению, и меньше или равен конечному значению
                    if ($j>=$start && $j<=$end) {

        // Ссылка на текущую страницу выделяется жирным
                        if ($j==($page)) echo ' <a class="page_active" href="'.base_url .$part_url .'?page=' . $j . '"><strong>' . $j . 
                            '</strong></a> &nbsp; ';

        // Ссылки на остальные страницы
                        else echo '<a class="page" href="' .base_url .$part_url .'?page=' . 
                            $j . '">' . $j . '</a> &nbsp; ';
                    }
                }

        // Выводим ссылки "вперед" и "на последнюю страницу"
                if ($j>$page && ($page+1)<$j) {

    // Чтобы попасть на следующую страницу нужно увеличить $pages на 2
                    echo '<a class="page" href="' .base_url .$part_url .'?page=' . ($page+1) . 
                    '"> ></a> &nbsp; ';

    // Так как у нас $j = количество страниц + 1, то теперь 
    // уменьшаем его на единицу и получаем ссылку на последнюю страницу
                    echo '<a class="page" href="' .base_url .$part_url .'?page=' . ($j-1) . 
                    '">>></a> &nbsp; </span>';
                }
            }
        }
        else {
            if (isset($_GET['articles'])) {
               
                ?>

                <div class="sidebar2">
                    <h1><?php echo $roww['title']."<br/>"; ?></h1>
                    <p><?php echo $roww['text']."<br/><br/>";   ?></p>
                    <?php if ($roww['image'] != '') { ?>
                    <img src="<?php echo base_url . 'media\articles\images'.DS.$roww['image'];?>" alt="<?php echo $roww['image'];?>"/><br/><br/>    
                    <?php } ?>
                    <?php 
                    if (isset($_SESSION['email'])) {            
                        if ($roww['doc'] != '') { ?>
                        <ul>
                            <li class="hover-save"><span class="save-right"><i class="fas fa-save"></i><a class="save-ic" href="<?php echo base_url . 'media\articles\doc'.DS.$roww['doc'];?>">Завантажити</a></span><br/>
                                <ul class="subsave">
                                    <li class="save-right"><?php echo $roww['doc'] ?></li>
                                </ul>
                            </li>
                        </ul>
                        <br/><br/>
                        <?php } } elseif ($roww['doc'] != '') {
                            echo "<p style='color: green;'>Щоб завантажити даний матеріал, Вам потрібно <a href=" .base_url . 'user/login' .">авторизуватися</a> на сайті!</p><br/>";
                        } ?>
                        <div class="bottom_sidebar">            
                            <i class="far fa-clock"></i> <?php echo $roww['date'];?> / <?php echo $roww['time']; ?>
                            <span class="author"><i class="fas fa-user-edit"></i><?php echo $roww['author']."<br/>"; ?></span>
                        </div>
                    </div>

                    <?php 
                }

            }

            ?>
        </div>

<?php 
} 
}

