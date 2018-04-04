<?php
/**
 * PHP Template.
 */
function __autoload($class_name) 
{
    $filename = strtolower($class_name) . '.php';
    $dir = 'classes';
    if(strpos($filename, 'block_') !== false){
        $filename = str_replace('_', DIRSEP, $filename);
        $dir = '';
    }
    $file = site_path . $dir . DIRSEP . $filename;
    if (file_exists($file) == false) {
        return false;
    }
    include ($file);
}