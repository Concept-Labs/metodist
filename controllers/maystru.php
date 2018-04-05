<?php
Class Controller_Maystru Extends Controller_Base 
{
    protected function _initTemplate($title)
    {
        //єто файл templates/index.phtml
        return parent::_initTemplate($title);
    }
    
    public function index() 
    {
        $template = $this->_initTemplate('Для майстра');
        
        //$template->set("data", "Hello", false);
        //$template->set("name", "Vitalik", false);
        $template->setFile('templates/maystru.phtml');
        
        $this->_renderLayout($template);
    }
    
    public function view() 
    {
        $template = $this->_initTemplate('this is view');
        
        //$template->set("data", "Hello", false);
        $template->set("name", "Vitalik", false);
        $template->setFile('templates/maystru/view.phtml');
        
        $this->_renderLayout($template);
    }
    
    public function add() 
    {
        $template = $this->_initTemplate('Добавте что-то в каталог');
        
        $template->setFile('templates/maystru/add.phtml');
        
        $this->_renderLayout($template);
    }
}
