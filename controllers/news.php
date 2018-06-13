<?php
Class Controller_News Extends Controller_Base 
{
    protected function _initTemplate($title)
    {
        //єто файл templates/index.phtml
        return parent::_initTemplate($title);
    }
    
    public function index() 
    {
        $template = $this->_initTemplate('Новини');
        
        $template->setFile('templates/news.phtml');

        $this->_renderLayout($template);
    }
    
}
