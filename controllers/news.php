<?php
Class Controller_News Extends Controller_Base 
{
    protected function _initTemplate($title, $description)
    {
       
        return parent::_initTemplate($title, $description);
      
    }
    
    public function index() 
    {
        $template = $this->_initTemplate('Новини', '');
        
        $template->setFile('templates/news.phtml');

        $this->_renderLayout($template);
    }
    
}
