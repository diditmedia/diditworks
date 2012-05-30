<?php

/**
 * -------------------------------------------------------------------
 * COMMON FUNCTIONS & HELPERS
 * -------------------------------------------------------------------
 * 
 * This file contains common functions and helpers that help get the
 * application up and running
 * 
 * @package diditworks
 * @author Paul Mulgrew <paul@diditmedia.com> 
 * 
 */
/*
 * --------------------------------------------------------------------
 * CLASS LOADING
 * --------------------------------------------------------------------
 * 
 * This is a helper function to get class files loaded.
 * it will return a reference to the object created and track which
 * objects have been initialized so we dont have multple instances of
 * the same object if we dont need them.
 * 
 */

/**
 * Helper function to load classes
 *
 * @param string $class         - the class to be loaded
 * @param string $dir             - the directory the class is located
 * @return object               - returns the created object or stored object if already created 
 */
function &load($class, $dir = 'core')
{
        //store loaded classes as an array
        static $loaded = array( );

        $class_name = '';

        //check if the class is in the loaded array
        //if it has already been loaded simply return it
        if(isset($loaded[$class]))
        {
                return $loaded[$class];
        }

        //check the system and application directories for the class
        foreach(array( SYS_PATH, APP_PATH ) as $path)
        {

                $loc = $path . SEP . $dir . SEP;

                //check if the file exists
                if(file_exists($loc . $class . EXT))
                {
                        //include it
                        require $loc . $class . EXT;
                        
                        //if the class has been found assign it to a new variable
                        $class_name = $class;

                        //stop looking for it if its been found
                        break;
                }
        }

        //check if we found the class
        if($class_name != '')
        {
                
                
                
                
                //instantuate the class and save it in the $loaded array
                $loaded[$class_name] = new $class_name;
                
                //track loaded classes
                class_is_loaded($class_name, $loaded[$class_name]);
                
                //return instance of the object
                return $loaded[$class_name];
        } else
        {
                exit('Class ' . $class . ' could not be found in ' . $loc);
        }

}

function class_is_loaded($name = NULL,$obj = NULL)
{
        static $_class_is_loaded = array();
        
        if(!is_null($name) && !is_null($obj))
        {
                $_class_is_loaded[$name] = $obj;
        } else {
                return $_class_is_loaded;
        }
}

/*
 * ------------------------------------------------------------------------------
 * GET CONFIG SETTINGS
 * ------------------------------------------------------------------------------
 * 
 * This helper function will return the value of a config key
 * 
 */

function get_config($key)
{
        global $config;
        
        if(array_key_exists($key, $config))
        {
                return $config[$key];
        } else {
                return false;
        }
}
/*
 * ------------------------------------------------------------------------------
 * GET INSTANCE
 * ------------------------------------------------------------------------------
 * 
 * returns an instance of te base controller
 */

function &get_instance()
{
        return controller::getInstance();
}

?>
