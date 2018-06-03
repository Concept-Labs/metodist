<?php
Class Controller_Index Extends Controller_Base 
{
    protected function _initTemplate($title)
    {

      return parent::_initTemplate($title);
      
  }

  public function index() 
  {

      $template = $this->_initTemplate('Панель управління');

      $template->setFile('templates/golovna.phtml');

      $db = $this->_registry->get('db');

        $result1 = mysqli_query($db, "SELECT * FROM `main` ORDER BY id DESC ");

//код для редагування статті
        $id = isset($_GET['id']) ? $_GET['id'] : 0; 


        $res = mysqli_query($db, "   SELECT * FROM `main` WHERE id='$id'");


        $roww = mysqli_fetch_array($res);
        $template->set('roww', $roww);

        if (isset($_POST['save'])) {
            $title = strip_tags(trim($_POST['title']));
            $text = strip_tags(trim($_POST['text']));
            $author = strip_tags(trim($_POST['author']));

            mysqli_query($db, "UPDATE `main` SET title='$title', text='$text', author='$author' WHERE id='$id'");
        }

//видалення статті
        if (isset($_GET['delete'])) {
            $delete = mysqli_query($db, "DELETE FROM `main` WHERE id='$id'");
            $template->set('delete', $delete);
        }

        mysqli_close($db);
        $template->set('result1', $result1);
// Считаем количество полученных записей
        $num_result = mysqli_num_rows($result1);
        $template->set('num_result', $num_result);

    $this->_renderLayout($template, true);
}
}