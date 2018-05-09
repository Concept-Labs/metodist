<?php
Abstract Class Controller_Base 
{
    protected $_registry;
    protected $_baseTemplate = null;
    protected $_session = null;
    
    function __construct($registry) 
    {
        if(!$this->_session){
            $this->_session = session_start();
        }
        $this->_registry = $registry;
        $this->_baseTemplate = $this->_registry->get('template');
    }

    
    abstract function index();

    protected function _initTemplate($title)
    {
		$this->_baseTemplate->addCss('styles/header.css');
		$this->_baseTemplate->addJs('');
        $this->_baseTemplate->addCss('styles/style.css');
		$this->_baseTemplate->addCss('styles/menu.css');
        $this->_baseTemplate->addCss('styles/storinky.css');
		$this->_baseTemplate->addCss('styles/site_content.css');
        $this->_baseTemplate->addCss('styles/metodrecommendations.css');
         $this->_baseTemplate->addCss('styles/footer.css');
		
		
        $parentTemplate = $this->_baseTemplate;
        $parentTemplate->set('title', $title);
        return clone $this->_registry->get('template');
    }

    protected function _renderLayout($template, $usePhp = false)
    {
        $parentTemplate = $this->_baseTemplate;
        
        $headerTemplate = clone $parentTemplate;
        $headerTemplate->setFile('templates/header.phtml');
            //header child 
            $headerMenu = new Block_Menu($this->_registry);
            $headerMenu->setFile('templates/header/menu.phtml');  
            $_htmlHeaderMenu = $headerMenu->toHtmlWithPhp();
        	$headerTemplate->set('headerMenu', $_htmlHeaderMenu);
        $_htmlheader = $headerTemplate->toHtmlWithPhp();
        $parentTemplate->set('header', $_htmlheader);
        
        $rightblockTemplate = clone $parentTemplate;
        $rightblockTemplate->setFile('templates/rightblock.phtml');
        $_htmlrightblock = $rightblockTemplate->toHtmlWithPhp();
        $parentTemplate->set('rightblock', $_htmlrightblock);
       
        if($usePhp){
            $html = $template->toHtmlWithPhp();
        } else {
            $html = $template->toHtml();
        }
        $parentTemplate->set('content', $template->toHtmlWithPhp());
        		
        $footerTemplate = clone $parentTemplate;
        $footerTemplate->setFile('templates/footer.phtml');
        $_htmlfooter = $footerTemplate->toHtmlWithPhp();
        $parentTemplate->set('footer', $_htmlfooter);
		
        
    }
}