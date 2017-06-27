<?php
error_reporting(E_ALL);

define('DIR_SEPARATOR', '/');
define('ROOT_DIR', dirname(__FILE__));

class AutoLoader
{
    /**
     * Generic class loader for controllers and models for autoloader
     * @param string $classname
     */
    public static function ClassLoader($classname) {
        $name_pieces = array_map('ucfirst', explode('_', $classname));
        $classpath = implode(DIR_SEPARATOR, $name_pieces);

        $filename = ROOT_DIR.DIR_SEPARATOR.$classpath .".php";
        if(file_exists($filename)) {
            require_once($filename);
        } else {
            die("Class $filename not found");
        }
    }
    
    /**
     * Config loader bulk from directory
     */
    public static function ConfigLoader()
    {
        $directory = ROOT_DIR . DIR_SEPARATOR . 'config/';

        foreach (glob($directory . "*.php") as $filename) {
            require_once $filename;
        }
    }
}

AutoLoader::ConfigLoader();

spl_autoload_register('AutoLoader::ClassLoader');
//spl_autoload_register('AutoLoader::ModelLoader');

?>