<?php
Class Block_Menu extends Template 
{
    public function getCurrentUrl()
    {
        return $_SERVER['REQUEST_URI'];
    }
}