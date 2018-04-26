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
        
        $this->_renderLayout($template);
    }
    
    public function teacher() 
    {
        $template = $this->_initTemplate('Рекомендації викладачу');
        $template->setFile('templates/metodrecommendations/teacher.phtml');
        

        $db = $this->_registry->get('db');
        if (!$db) {
            echo "Ошибка: Невозможно установить соединение с MySQL." . PHP_EOL;
            echo "Код ошибки errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Текст ошибки error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }
        $result = mysqli_query($db, "   SELECT id, title, text, date, time, author FROM teacher ORDER BY id DESC ");
        
        $template->set('result', $result);

        mysqli_close($db);

        $this->_renderLayout($template);
    }
    
    public function master() 
    {
        $template = $this->_initTemplate('Рекомендації майстру в/н');
        $template->setFile('templates/metodrecommendations/master.phtml');
        $this->_renderLayout($template);
    }

    public function chairman_mk() 
    {
        $template = $this->_initTemplate('Рекомендації голові МК');
        $template->setFile('templates/metodrecommendations/chairman_mk.phtml');
        $this->_renderLayout($template);
    }

    public function young_teacher() 
    {
        $template = $this->_initTemplate('Рекомендації молодому педагогу');
        $template->setFile('templates/metodrecommendations/young_teacher.phtml');
        $this->_renderLayout($template);
    }

    public function class_teacher() 
    {
        $template = $this->_initTemplate('Рекомендації класному керівнику');
        $template->setFile('templates/metodrecommendations/class_teacher.phtml');
        $this->_renderLayout($template);
    }
}
