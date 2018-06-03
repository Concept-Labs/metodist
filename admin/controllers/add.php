<?php
Class Controller_Add Extends Controller_Base 
{
    protected function _initTemplate($title)
    {
        //єто файл templates/index.phtml
        return parent::_initTemplate($title);
    }
    
    public function index() 
    {
        $template = $this->_initTemplate('Додавання матеріалу');

        $template->setFile('templates/add.phtml');
        
        $db = $this->_registry->get('db');
        $data = $_POST;
        $errore = array();

        if (isset($data['add'])) {

            $title = strip_tags(trim($data['title']));
            $text = quotemeta($data['text']);
            $section = $data['section'];
            $author = strip_tags(trim($data['author']));
            $date = $data['date'];
            $time = $data['time'];

            // Проверяем пришел ли файл
            $img = $_FILES['image']['name'];
            if( !empty($img) ) {
  // Проверяем, что при загрузке не произошло ошибок
              if ( $_FILES['image']['error'] == 0 ) {
    // Если файл загружен успешно, то проверяем - графический ли он
                if( substr($_FILES['image']['type'], 0, 5)=='image' ) {
      // Читаем содержимое файла
                  $image = $_FILES['image']['tmp_name'];
      
                  $location = 'c:\xampp\htdocs\metodist\media\articles\images'.DS.$img;
                  $copy = copy($image, $location);
                  if (!$copy) {
                    $errore = 'Зображення не скопійовано!';
                }


            }else {$errore = 'Файл не графічний!';}
        }else {$errore = 'Є ошибки по зображеню!';}
    }

    // Проверяем пришел ли файл
            $doc = $_FILES['doc']['name'];
            if( !empty($doc) ) {
  // Проверяем, что при загрузке не произошло ошибок
              if ( $_FILES['doc']['error'] == 0 ) {
 
      // Читаем содержимое файла
                  $docum = $_FILES['doc']['tmp_name'];
      
                  $location = 'c:\xampp\htdocs\metodist\media\articles\doc'.DS.$doc;
                  $copy = copy($docum, $location);
                  if (!$copy) {
                    $errore = 'Документ не скопійовано!';
                }


            }else {$errore = 'Є ошибки по документу!';}
    }

    if (empty(trim($title))) {
        $errore = "Введіть заголовок матеріалу!";
    } 
    elseif (empty(trim($text))) {
        $errore = 'Введіть текст матеріалу!';
    } 
    elseif (empty(trim($author))) {
        $errore = 'Введіть хто додав матеріал!';
    } 

    if (empty($errore)) { 

        mysqli_query($db, "INSERT INTO $section (title, text, image, doc, date, time, author) VALUES ('$title', '$text', '$img', '$doc', '$date', '$time', '$author')");
  }

}
$template->set('errore', $errore);
mysqli_close($db);

$this->_renderLayout($template);
}
}