<?php
/**
 * Automatically includes classes
 * 
 * @throws Exception
 * 
 * @param  string $class_name  Name of the class to load
 * @return void
 */
function __autoload($class_name)
{
    // Customize this to your root Flourish directory
    $flourish_root = '/home/richam/public_html/turismoenlinea.org/flourish/';
	//$flourish_root = $_SERVER['DOCUMENT_ROOT'] . '/turismoenlinea/flourish/';
    
    $file = $flourish_root . $class_name . '.php';
 
    if (file_exists($file)) {
        include $file;
        return;
    }
    
    throw new Exception('The class ' . $class_name . ' could not be loaded');
}
?>