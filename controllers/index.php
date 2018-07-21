<?php
Class Controller_Index Extends Controller_Base 
{
    protected function _initTemplate($title, $description)
    {
       
		return parent::_initTemplate($title, $description);
      
	}

    public function index() 
    {
     	
		$template = $this->_initTemplate('Metodist', 'Інформаційний сайт');
        
        $template->setFile('templates/main.phtml');

        $this->_renderLayout($template, true);
    }
}