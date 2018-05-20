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
            $query= mysqli_query($db, " SELECT * FROM `teacher` WHERE $query_search 
                UNION SELECT * FROM `master` WHERE $query_search 
                UNION SELECT * FROM `chairman_mk` WHERE $query_search
                UNION SELECT * FROM `young_teacher` WHERE $query_search
                UNION SELECT * FROM `class_teacher` WHERE $query_search
                UNION SELECT * FROM `attestation` WHERE $query_search
                UNION SELECT * FROM `internship` WHERE $query_search
                UNION SELECT * FROM `pedagogical_experience` WHERE $query_search
                UNION SELECT * FROM `qualifications` WHERE $query_search
                UNION SELECT * FROM `news` WHERE $query_search
                UNION SELECT * FROM `main` WHERE $query_search");

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
