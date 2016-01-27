<?php
class Session {
    
    private static $cleared_old_flash = false;
    private static $flash = [];
    
    public function __construct() {
        //start the session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        //capture and clear old flash data from previous request
        $this->clear_old_flash();
    }
    
    public function clear_old_flash() {
        
        // if flash already cleared don't do anything
        if(self::$cleared_old_flash == true) return;
        
        $flash_vars = $this->get('flash');
        
        if(!empty($flash_vars) && is_array($flash_vars)) {
            foreach( $flash_vars as $var ) {
                self::$flash[$var] = $this->get($var);
                $this->remove($var);
            }
        }
        $this->remove('flash');
        self::$cleared_old_flash = true;
    }
    
    /*
     * set value of a session variable
     */
    public function set($name,$value) {
        $_SESSION[$name] = $value;
    }
    
    /*
     * get value of session variable
     * first checks for flash and then session
     */
    public function get($name) {
        if( isset(self::$flash[$name]) ) {
            return self::$flash[$name];
        }
        elseif( isset($_SESSION[$name]) ) {
            return $_SESSION[$name];
        }
        else {
            return null;
        }
    }
    
    public function remove($name) {
        unset($_SESSION[$name]);
    }
    
    /*
     * @param $name: could be a string or an associative array
     * @param string $value: optional if $name is array
     */
    public function flash($name,$value='') {
        
        if( empty($name) )
        return;
        
        // Set value of session variable
        $this->set($name,$value);
        
        // Get currently saved flash variables array
        $flash = $this->get('flash') ? $this->get('flash') : [];
        
        // Append the new passed variable
        $flash[] = $name;
        
        // Save the flash session variable
        $this->set('flash',$flash);
        
    }
    
}