<?php
class Controller_Base {
	protected $method;
    
	protected function __construct($method, $input) {
	}    
    
    protected function validateMethod($method) {
        if(strtolower($this->method) == strtolower($method)) {
            return true;
        }
        return false;
    }
    
}
?>
