<?php
Class Controller_Qualifications Extends Controller_Base 
{
    protected function _initTemplate($title)
    {
        //єто файл templates/index.phtml
        return parent::_initTemplate($title);
    }
    
    public function index() 
    {
        $template = $this->_initTemplate('Підвищення кваліфікації');
        
        $template->setFile('templates/qualifications.phtml');
        
        $this->_renderLayout($template);
    }
}