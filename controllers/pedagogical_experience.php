<?php
Class Controller_Pedagogical_Experience Extends Controller_Base 
{
    protected function _initTemplate($title, $description)
    {
       
        return parent::_initTemplate($title, $description);
      
    }
    
    public function index() 
    {
        $template = $this->_initTemplate('Поширення педагогічного досвіду', '');
        
        $template->setFile('templates/pedagogical_experience.phtml');

        $this->_renderLayout($template);
    }
}