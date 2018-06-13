<?php
Class Controller_Internship Extends Controller_Base 
{
    protected function _initTemplate($title)
    {
        //єто файл templates/index.phtml
        return parent::_initTemplate($title);
    }
    
    public function index() 
    {
        $template = $this->_initTemplate('Стажування');
        
        $template->setFile('templates/internship.phtml');

        $this->_renderLayout($template);
    }
}