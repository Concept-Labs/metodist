<?php
Class Controller_Career_Guidance Extends Controller_Base 
{
    protected function _initTemplate($title, $description)
    {
       
        return parent::_initTemplate($title, $description);
      
    }
    
    public function index() 
    {
        $template = $this->_initTemplate('Профорієнтація', 'ntc');
        
        $template->setFile('templates/career_guidance.phtml');

        $this->_renderLayout($template);
    }
    
}
