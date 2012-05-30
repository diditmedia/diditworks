<?php

/**
 * ------------------------------------------------------------------------
 * BASE CONTROLLER
 * ------------------------------------------------------------------------
 * 
 * This is the base controller. all other controllers must extend this one
 *
 * @author Paul Mulgrew
 */
class controller
{

        //holds a reference to itself within the instance property
        private static $instance;

        /*
         * constructor method 
         * 
         * this method will set a reference to itself in the $instance property
         */

        public function __construct()
        {
                self::$instance = & $this;
                
                //assign each class already loaded to the $this->$var property
                //This way we can access all classes easily within the controller
                foreach(class_is_loaded() as $var => $class)
                {            
                        $this->$var = $class;
                }
                
                

        }

        

        //public method getInstance will allow you to get an instance of this class from outside of the class
        public static function &getInstance()
        {
                return self::$instance;

        }

}

?>
