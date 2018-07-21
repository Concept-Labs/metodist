<?php
Class Controller_Internship Extends Controller_Base 
{
    protected function _initTemplate($title, $description)
    {
       
        return parent::_initTemplate($title, $description);
      
    }
    
    public function index() 
    {
        $template = $this->_initTemplate('Стажування', '');
        
        $template->setFile('templates/internship.phtml');

        $this->_renderLayout($template);
    }
}