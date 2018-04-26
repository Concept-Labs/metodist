<?php
Class Controller_Index Extends Controller_Base 
{
    protected function _initTemplate($title)
    {
       
		return parent::_initTemplate($title);
      
	}

    public function index() 
    {
     	
		$template = $this->_initTemplate('Metodist');
        
        $template->setFile('templates/main.phtml');

        $this->_renderLayout($template, true);
    }
}