<?php
debug::log('Router file loaded', 4);

/**
 * -----------------------------------------------------------------------
 * ROUTER CLASS
 * -----------------------------------------------------------------------
 * 
 * The router is responsible for loading the controllers and methods requested 
 * via the url.
 * 
 * The router looks first for the controller then the method and then sends the rest
 * of the URL as parameters
 * 
 * Example: www.example.com/blog/single/10 would load the blog controller then call
 * the single method and pass a parameter of 10 to the single method
 * 
 * @package diditworks
 * @author Paul Mulgrew
 */
class router
{


        //save the url parts to this property
        protected $_url_parts;

        protected $_controller = false;

        protected $_method = false;

        protected $_params = false;

        protected $_key = false;

        //on load the construct method will get the url parts
        function __construct()
        {
                //load the config instance
                $this->config = & load('config');

                //get the uri request
                $url = $_SERVER['REQUEST_URI'];

                //remove the root folder if there is one and trim and trailing slashes
                $url = trim(str_replace(ROOT, '', trim($url, '/')), '/');

                //explode the url to an array
                $this->_url_parts = explode('/', $url);

                //get the loader class instance
                $this->load = & load('loader');

                //call the get_parts method
                $this->get_parts();

        }


        protected function get_parts()
        {

                $_parts = $this->_url_parts;

                $route = $this->config->key('route');


                //check if the 1st element of the url array has a value
                if($_parts[0] == '')
                {
                        //if it doesnt load the default route
                        $this->_set_defaults();
                }
                else
                {
                        //check if routes are setup

                        if($route)
                        {
                                //1st check if a route is setup
                                if(key_exists($_parts[0], $route))
                                {
                                        $this->_controller = $route[$_parts[0]];
                                }
                                else
                                {
                                        $this->_controller = $_parts[0];
                                }
                        }
                        else
                        {
                                $this->_controller = $_parts[0];
                        }




                        //check for a method
                        if(key_exists('1', $_parts))
                        {
                                //if it exists assign it to the method property
                                $this->_method = $_parts[1];
                        }
                        else
                        {
                                //otherwise set it to index
                                $this->_method = 'index';
                        }

                        if(key_exists('2', $_parts))
                        {
                                $this->_set_params();
                        }
                }



                $this->load_controller();

        }


        protected function _set_defaults()
        {


                //get the default route from the config file
                $_default = $this->config->key('default_route');

                //set route as the default route
                $this->_controller = $_default;

                //set method as index. The default method will always 
                //be index if no method is called
                $this->_method = 'index';

        }


        protected function _set_params()
        {
                $_parts = $this->_url_parts;

                if(key_exists('2', $_parts))
                {
                        unset($_parts[0]);
                        unset($_parts[1]);

                        $this->_key = $_parts[2];


                        unset($_parts[2]);
                }

                //check if there are any more url segments
                if(!empty($_parts))
                {
                        $this->_params = array_values($_parts);
                }

        }


        protected function load_controller($controller = NULL)
        {
                //if controller is null and the _default_route is not false
                //then set the $controller as the default route
                if(is_null($controller) && $this->_controller !== false)
                {
                        $controller = $this->_controller;
                }
                elseif(is_null($controller) && $this->_controller === false)
                {
                        dm_error::display_error('No route or default route set');
                }
                elseif($this->_controller !== false)
                {
                        $controller = $this->_controller;
                }


                //set the path to the controller directory
                $path = APP_PATH . SEP . $this->config->key('controllers') . SEP;


                if(file_exists($path . $controller . EXT))
                {
                        //load the default controller
                        $c = $this->load->controller($controller);
                        if(method_exists($c, $this->_method))
                        {

                                //check for keys or additional params
                                if($this->_key !== false && $this->_params === false)
                                {

                                        //pass key
                                        $c->{$this->_method}($this->_key);
                                }
                                elseif($this->_key !== false && $this->_params !== false)
                                {

                                        //pass key and params
                                        $c->{$this->_method}($this->_key, $this->_params);
                                }
                                else
                                {

                                        //pass nothing
                                        $c->{$this->_method}();
                                }
                        }
                        else
                        {
                                dm_error::display_error('Method: ' . $this->_method . ' does not exist');
                        }
                }
                else
                {
                        dm_error::display_error('The controller: ' . $controller . ' could not be found');
                }

        }


}

?>
