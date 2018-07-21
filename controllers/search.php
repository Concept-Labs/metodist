<?php
Class Controller_Search Extends Controller_Base 
{
    protected function _initTemplate($title, $description)
    {
       
        return parent::_initTemplate($title, $description);
      
    }
    
    public function index() 
    {
        $template = $this->_initTemplate('Пошук', '');
        
        $template->setFile('templates/search.phtml');
        
        $db = $this->_registry->get('db');

        $search_error = array();

        if (isset($_GET['search'])) {
            $search_query=htmlspecialchars(strip_tags(trim($_GET['search_query'])));
            $query_search = '';
            $array_search_query = explode(' ', $search_query);
            foreach ($array_search_query as $key => $value) {
                if (isset($array_search_query[$key - 1])) {
                    if (!isset($_GET['allwords'])) {
                        $query_search .= ' OR ';
                    } else {
                        $query_search .= $_GET['allwords'];
                    }                    
                }
                $query_search .= "(`title` LIKE '%$value%' OR `text` LIKE '%$value%')";
            }
            $query= mysqli_query($db, " SELECT *, 'teacher' AS 'table' FROM `teacher` WHERE $query_search 
                UNION SELECT *, 'master' AS 'table' FROM `master` WHERE $query_search 
                UNION SELECT *, 'chairman_mk' AS 'table' FROM `chairman_mk` WHERE $query_search
                UNION SELECT *, 'young_teacher' AS 'table' FROM `young_teacher` WHERE $query_search
                UNION SELECT *, 'class_teacher' AS 'table' FROM `class_teacher` WHERE $query_search
                UNION SELECT *, 'attestation' AS 'table' FROM `attestation` WHERE $query_search
                UNION SELECT *, 'internship' AS 'table' FROM `internship` WHERE $query_search
                UNION SELECT *, 'pedagogical_experience' AS 'table' FROM `pedagogical_experience` WHERE $query_search
                UNION SELECT *, 'qualifications' AS 'table' FROM `qualifications` WHERE $query_search
                UNION SELECT *, 'news' AS 'table' FROM `news` WHERE $query_search
                UNION SELECT *, 'main' AS 'table' FROM `main` WHERE $query_search");

            $num = mysqli_num_rows($query);

            if (empty($_GET['search_query'])) {
                $search_error = 'Уведіть ваш запит пошуку!';
            } elseif ($num == 0) {
                $search_error = 'По вашому запиту "'.$search_query.'" нічого не знайдено!';
            }


        }
        $template->set('search_query', $search_query);
        $template->set('query', $query);
        $template->set('num', $num);
        $template->set('search_error', $search_error);
        mysqli_close($db);       

        $this->_renderLayout($template);
    }

}
