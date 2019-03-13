<?php
Class Controller_Career_Guidance Extends Controller_Base 
{
    protected function _initTemplate($title)
    {
       
        return parent::_initTemplate($title);
      
    }
    
    public function index() 
    {
        $template = $this->_initTemplate('Профорієнтація');
        
        $template->setFile('templates/career_guidance.phtml');

        $this->_renderLayout($template);
    }
    
}
