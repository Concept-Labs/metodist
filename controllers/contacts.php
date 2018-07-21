<?php
Class Controller_Contacts Extends Controller_Base 
{
    protected function _initTemplate($title, $description)
    {
       
        return parent::_initTemplate($title, $description);
      
    }
    
    public function index() 
    {
        $template = $this->_initTemplate('Контакти', '');
        
        $template->setFile('templates/contacts.phtml');
               

        $this->_renderLayout($template);
    }
    
}
