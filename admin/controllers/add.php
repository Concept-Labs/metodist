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
            $text = strip_tags(trim($data['text']));
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
      // Экранируем специальные символы в содержимом файла
                 // $image = mysqli_escape_string($db, $images );
                  $location = 'c:\xampp\htdocs\metodist\media\articles\images'.DS.$img;
                  $copy = copy($image, $location);
                  if (!$copy) {
                    $errore = 'Файл не скопійовано!';
                }


            }else {$errore = 'Файл не графічний!';}
        }else {$errore = 'Є ошибки по зображеню!';}
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

        mysqli_query($db, "INSERT INTO $section (title, text, image, date, time, author) VALUES ('$title', '$text', '$img', '$date', '$time', '$author')");
  }

}
$template->set('errore', $errore);
mysqli_close($db);

$this->_renderLayout($template);
}
}