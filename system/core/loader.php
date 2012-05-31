<?php

/**
 * The loader class will assist in loading various components of the application
 *
 * @package diditworks
 * @author Paul Mulgrew
 * @todo this entire class needs reworked
 */
class loader
{


        protected $_core_classes = array( );

        protected $_is_loaded = array( );

        /**
         * 
         */
        function __construct()
        {
                //assign object to config property
                $this->config = & load('config');

                //get the core classes config setting
                $this->_core_classes = $this->config->key('core_classes');
                
                //check if any auto_include files are set
                if($this->config->key('auto_include'))
                {
                        
                        $auto = $this->config->key('auto_include');
                        
                        
                        
                        foreach($auto as $include)
                        {
                                
                                $this->load_file($include['file'], $include['path']);
                        }
                }

                //$this->test =& load('config');
                //load the core classes
                $this->load_core();

        }


        /**
         * Loads the core classes 
         */
        function load_core()
        {
                //check if it is an array
                if(is_array($this->_core_classes))
                {
                        //load each class listed in core_classes
                        $this->loader($this->_core_classes);
                }
                else
                {
                        exit('Config item core_classes is not configured properly');
                }

        }


        /**
         *  loader method
         * 
         * This method will load the classes called by the controller
         * 
         * 
         * @param mixed $classes this method will accept a single class as a string or multiple
         * classes as an array. the array will be formed as $variablename => $classname
         */
        public function loader($classes = NULL)
        {
                //check that a value was passed to the method
                if(!is_null($classes))
                {
                        //check if the value is an array
                        if(is_array($classes))
                        {
                                //loop through the array 
                                foreach($classes as $var => $class)
                                {
                                        //assign all class object to the local variable $this
                                        //this will allow access to all classes through $this
                                        //this will allow the controller to act as a super object
                                        $loaded = & load($class);

                                        $this->set_is_loaded($class, $loaded);
                                }
                        }
                        else
                        {
                                //for ease of readability reassign classes to class
                                $class = $classes;

                                $loaded = & load($class);

                                $this->set_is_loaded($class, $loaded);
                        }
                }

        }


        /**
         * This method will set objects that have been loaded into an array
         * 
         * @param string $key           - name of loaded object
         * @param object $obj           - reference to the loaded object 
         */
        protected function set_is_loaded($key = NULL, $obj = NULL)
        {
                if(!is_null($key) && !is_null($obj))
                {
                        $this->_is_loaded[$key] = $obj;
                }

        }


        //return all loaded objects
        public function get_is_loaded()
        {

                return $this->_is_loaded;

        }


        /**
         *      
         * 
         * @param string $controller 
         */
        function controller($controller)
        {
                // assign the path to a variable
                $path = $this->config->key('controllers');

                //make sure the path is real
                if(is_dir(APP_PATH . SEP . $path))
                {
                        //and that the file exists
                        if(file_exists(APP_PATH . SEP . $path . SEP . $controller . EXT))
                        {
                                //now load it
                                $loaded = & load($controller, $path);

                                //and track the loaded object
                                $this->set_is_loaded($controller, $loaded);
                        }

                        //return the object
                        return $loaded;
                }

        }


        //loads a model
        function model($model)
        {
                $path = $this->config->key('models');

                if(is_dir(APP_PATH . SEP . $path))
                {
                        if(file_exists(APP_PATH . SEP . $path . SEP . $model . EXT))
                        {
                                $loaded = & load($model, $path);

                                $this->set_is_loaded($model, $loaded);
                        }
                        else
                        {
                                exit('Model: ' . $model . ' Could not be found');
                        }

                        return $loaded;
                }

        }


        //loads a view
        function view($view, $data = NULL)
        {
                $path = $this->config->key('views');

                if(is_dir(APP_PATH . SEP . $path))
                {
                        if(file_exists(APP_PATH . SEP . $path . SEP . $view . EXT))
                        {
                                $loaded = & load('view');

                                $this->set_is_loaded('view', $loaded);
                        }

                        $loaded->add_output($view, $data);

                        return $loaded;
                }
                else
                {
                        exit('view: ' . $view . ' does not exist');
                }

        }


        /**
         * --------------------------------------------------------------
         * LOAD HELPERS
         * --------------------------------------------------------------
         * 
         * This method will load the helper files.
         * 
         * @param string $helper 
         */
        public function helper($helper)
        {
                if(is_dir(SYS_PATH . SEP . 'helpers'))
                {
                        if(file_exists(SYS_PATH . SEP . 'helpers' . SEP . $helper.EXT))
                        {
                                require_once(SYS_PATH . SEP . 'helpers' . SEP . $helper.EXT);
                        }
                        else
                        {
                                exit('Helper: ' . $helper . ' does not exist');
                        }
                }

        }
        
        /**
         * -----------------------------------------------------------
         * INCLUDE FILES
         * -----------------------------------------------------------
         * 
         * This method will include files needed by the application.
         * 
         * You shoudl use this method to load class files that will need to initialized later
         * or that will need to have multiple objects created as the loader method works as a singleton
         * 
         * This file is intended for use in the application side as system files
         * will be automatically loaded or will be loaded using the loader method.
         *  
         * 
         * @param string $file
         * @param string $path 
         */
        public function load_file($file = NULL, $path = 'classes')
        {
                $path = str_replace('/', SEP, $path);
                //check that the path and file exist
                if(is_dir(APP_PATH.SEP.$path) && file_exists(APP_PATH.SEP.$path.SEP.$file.EXT))
                {
                        require_once(APP_PATH.SEP.$path.SEP.$file.EXT);
                        
                        //dm_logger::debug('LOADING: '.APP_PATH.SEP.$path.SEP.$file.EXT);
                }
                
        }


}

?>
