<?php
Class Controller_Contacts Extends Controller_Base 
{
    protected function _initTemplate($title)
    {
        //єто файл templates/index.phtml
        return parent::_initTemplate($title);
    }
    
    public function index() 
    {
        $template = $this->_initTemplate('Контакти');
        
        $template->setFile('templates/contacts.phtml');
               

        $this->_renderLayout($template);
    }
    
}
