<?php
Class Controller_Attestation Extends Controller_Base 
{
    protected function _initTemplate($title, $description)
    {
       
        return parent::_initTemplate($title, $description);
      
    }
    
    public function index() 
    {
        $template = $this->_initTemplate('Атестація', 'ntc');
        
        $template->setFile('templates/attestation.phtml');

        $this->_renderLayout($template);
    }
    
}
