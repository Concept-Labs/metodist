<?php
Class Block_Logining extends Template 
{
    public function getCurrentUrl()
    {
        return $_SERVER['REQUEST_URI'];
    }
}