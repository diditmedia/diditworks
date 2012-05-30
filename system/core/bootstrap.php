<?php

/**
 * --------------------------------------------------------------------
 * BOOTSTRAP
 * --------------------------------------------------------------------
 * 
 * The bootstrap is going to load all files and classes need to get the
 * application up and running.
 * 
 * @package diditworks
 * @author Paul Mulgrew <paul@diditmedia.com> 
 */

/*
 * --------------------------------------------------------------------
 * CONFIGURATION FILES
 * --------------------------------------------------------------------
 * 
 * We need to load the main config file config.php
 * located in application/config
 * 
 */

//load the config file
if(file_exists(APP_PATH . SEP . 'config' . SEP . 'config.php'))
{
        require APP_PATH . SEP . 'config' . SEP . 'config.php';
} else
{
        exit('The config file is missing');
}

/*
 * --------------------------------------------------------------------
 * COMMON FUNCTIONS & HELPERS
 * --------------------------------------------------------------------
 * 
 * Load the common.php file
 *  
 */

require SYS_PATH . SEP . 'core' . SEP . 'common.php';

//now we load the loader object
if(function_exists('load'))
{
        $DM->load =& load('loader', 'core');
}

/*
 * --------------------------------------------------------------------
 * LOAD BASE CONTROLLER
 * --------------------------------------------------------------------
 * 
 */

$DM->load->loader('controller');


/*
 * -------------------------------------------------------------------
 * LOAD ROUTER 
 * -------------------------------------------------------------------
 * 
 */

$DM->load->loader('router');











