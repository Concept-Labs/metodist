<?php
Class Controller_Search Extends Controller_Base 
{
    protected function _initTemplate($title)
    {
        //єто файл templates/index.phtml
        return parent::_initTemplate($title);
    }
    
    public function index() 
    {
        $template = $this->_initTemplate('Пошук');
        
        $template->setFile('templates/search.phtml');
        
        $db = $this->_registry->get('db');


if (isset($_POST['search'])) {
    $search_query=strip_tags(trim($_POST['search_query']));

$query= mysqli_query($db, "   SELECT * FROM metodrecommendations WHERE title LIKE '%$search_query%'");
}
$template->set('query', $query);
mysqli_free_result($query);
mysqli_close($db);       

        $this->_renderLayout($template);
    }
    
}
