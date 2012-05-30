<?php

/**
 * -------------------------------------------------------------------
 * FORMS LIBRARY
 * -------------------------------------------------------------------
 * 
 * This class will help us create forms and form elements
 *
 * @package diditworks
 * @author Paul Mulgrew
 */
class forms
{

        /**
         * -----------------------------------------------------------------
         * FORM METHOD
         * -----------------------------------------------------------------
         * 
         * This method will create an open form tag
         * 
         * @param string $action        - a string containing the action
         * @param string $method        - a string containing the method (defaults to POST)
         * @param array $params         - an array of key/value params
         * @return string               - returns a string containing the opening form tag 
         */
        public function form($action = NULL, $method = NULL, $params = NULL)
        {

                //Check if an action was passed
                if(is_null($action))
                {
                        //if not set the defaul to the current page
                        $_action = 'action="' . $_SERVER['REQUEST_URI'] . '" ';
                } else
                {
                        //otherwise set it to what the user passed
                        $_action = 'action="' . $action . '" ';
                }

                //check if a method has been passed
                if(is_null($method))
                {
                        //if not set the method to POST
                        $_method = 'method="POST" ';
                } else
                {
                        //otherwise set the method to what the user passed
                        $_method = 'method="' . $method . '"';
                }

                //initialise the $_params variable
                $_params = '';

                //check if params were passed and that they are an array
                if(!is_null($params) && is_array($params))
                {
                        //loop through the params
                        foreach($params as $attr => $value)
                        {
                                $_params .= $attr . '="' . $value . '" ';
                        }
                }

                //put it all together
                $_form = '<form ' . $_action . $_method . $_params . '>';

                //return the opening form
                return $_form;

        }
        
        /**
         * -----------------------------------------------------------------------
         * INPUT
         * -----------------------------------------------------------------------
         * 
         * This method will create an input field
         * 
         * @param string $type          - string containing the input type (default = text)
         * @param string $name          - string contianing the input name
         * @param array $params         - an array of key/value pairs for attributes
         * @return string               - return a string with the input tag
         */
        public function input($type = NULL, $name = NULL, $params = NULL)
        {
                //check if a value was passed
                if(is_null($type))
                {
                        $_type = 'type="text" ';
                } else
                {
                        $_type = 'type="' . $type . '" ';
                }
                
                //check if a vlue was passed
                if(!is_null($name))
                {
                        $_name = 'name="' . $name . '" ';
                } else
                {
                        $_name = '';
                }
                
                //initialize the $_params
                $_params = '';
                
                //check if params were passed and that it is an array
                if(!is_null($params) && is_array($params))
                {
                        foreach($params as $attr => $value)
                        {
                                $_params .= $attr.'="'.$value.'" ';
                        }
                }
                
                //build the string
                $_input = '<input '.$_type.$_name.$_params.' />';
                
                //return the final string
                return $_input;

        }

}

?>
