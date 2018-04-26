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
        $result = mysqli_query($db, " SELECT id, title, text, date, time, author FROM chairman_mk AND teacher ORDER BY date DESC ");

        
        $template->set('result', $result);

        mysqli_close($db);

        $this->_renderLayout($template);
    }
    
    public function teacher() 
    {
        $template = $this->_initTemplate('Рекомендації викладачу');
        $template->setFile('templates/metodrecommendations/teacher.phtml');
        

        $db = $this->_registry->get('db');
        $result = mysqli_query($db, "   SELECT id, title, text, date, time, author FROM teacher ORDER BY id DESC ");
        
        $template->set('result', $result);

        mysqli_close($db);

        $this->_renderLayout($template);
    }
    
    public function master() 
    {
        $template = $this->_initTemplate('Рекомендації майстру в/н');
        $template->setFile('templates/metodrecommendations/master.phtml');

        $db = $this->_registry->get('db');
        $result = mysqli_query($db, "   SELECT id, title, text, date, time, author FROM master ORDER BY id DESC ");
        
        $template->set('result', $result);

        mysqli_close($db);
        $this->_renderLayout($template);
    }

    public function chairman_mk() 
    {
        $template = $this->_initTemplate('Рекомендації голові МК');
        $template->setFile('templates/metodrecommendations/chairman_mk.phtml');

        $db = $this->_registry->get('db');
        $result = mysqli_query($db, "   SELECT id, title, text, date, time, author FROM chairman_mk ORDER BY id DESC ");
        
        $template->set('result', $result);

        mysqli_close($db);
        $this->_renderLayout($template);
    }

    public function young_teacher() 
    {
        $template = $this->_initTemplate('Рекомендації молодому педагогу');
        $template->setFile('templates/metodrecommendations/young_teacher.phtml');

        $db = $this->_registry->get('db');
        $result = mysqli_query($db, "   SELECT id, title, text, date, time, author FROM young_teacher ORDER BY id DESC ");
        
        $template->set('result', $result);

        mysqli_close($db);
        $this->_renderLayout($template);
    }

    public function class_teacher() 
    {
        $template = $this->_initTemplate('Рекомендації класному керівнику');
        $template->setFile('templates/metodrecommendations/class_teacher.phtml');

        $db = $this->_registry->get('db');
        $result = mysqli_query($db, "   SELECT id, title, text, date, time, author FROM class_teacher ORDER BY id DESC ");
        
        $template->set('result', $result);

        mysqli_close($db);
        $this->_renderLayout($template);
    }
}
