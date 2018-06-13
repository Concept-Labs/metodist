<?php
Class Controller_Attestation Extends Controller_Base 
{
    protected function _initTemplate($title)
    {
        //єто файл templates/index.phtml
        return parent::_initTemplate($title);
    }
    
    public function index() 
    {
        $template = $this->_initTemplate('Атестація');
        
        $template->setFile('templates/attestation.phtml');

        $this->_renderLayout($template);
    }
    
}
