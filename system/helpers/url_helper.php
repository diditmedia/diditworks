<?php

/**
 * The purpose of this file is to perform various url related functions
 * 
 * @author Paul Mulgrew <paul@diditmedia.com> 
 */


/*
 * --------------------------------------------------------------------
 * GET SEGMENT
 * --------------------------------------------------------------------
 * 
 * This function will return the value of the URL segment requested
 * 
 */

if(!function_exists('url_segment'))
{
        function url_segment($seg)
        {
                //get the uri request
                $url = $_SERVER['REQUEST_URI'];

                //remove the root folder if there is one and trim and trailing slashes
                $url = trim(str_replace(ROOT, '', trim($url, '/')), '/');

                //explode the url to an array
                $_url_parts = explode('/', $url);
                
                return $_url_parts[$seg -1];
        }
}


?>
