<?php

/**
 * ----------------------------------------------------------------
 * REQUEST CLASS
 * ----------------------------------------------------------------
 * 
 * This class will deal post and get data etc
 * 
 * @package diditworks
 * @author Paul Mulgrew
 */
class requests
{


        //store $_POST
        protected $_post_data;

        //store $_GET
        protected $_get_data;

        public function __construct()
        {
                if(isset($_POST))
                {
                        $this->_post_data = $_POST;
                }

                if(isset($_GET))
                {
                        $this->_get_data = $_GET;
                }

        }


        public function post($key)
        {
                if(key_exists($key, $this->_post_data))
                {
                        filter_var($this->_post_data[$key], FILTER_SANITIZE_STRING);
                }

        }


}

?>
