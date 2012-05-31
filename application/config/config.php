<?php

/**
 * ----------------------------------------------------------------
 * CONFIG FILE
 * ----------------------------------------------------------------
 * 
 * this file contains config values held in an array called $config
 * each key in the array holds a config item
 * 
 * @package diditworks
 * @author Paul Mulgrew <paul@diditmedia.com> 
 */

/*
 * ----------------------------------------------------------------
 * CORE CLASSES
 * ----------------------------------------------------------------
 * 
 * Set which core classes should be loaded automatically
 * 
 */

$config['core_classes'] = array('config','model', 'debug');

//automatically load these helpers
$config['helpers'] = array('url_segment');

//automatically load these libraries
$config['libraries'] = array();

/*
 * ----------------------------------------------------------------
 * AUTO INCUDE APPLICATION FILES
 * ----------------------------------------------------------------
 * 
 * Set the files that should be included in your application.
 * Set one file per line in the following format:
 * 
 * $config['auto_include'] = array('file' => 'file', 'path' => 'path');
 * $config['auto_include'] = array('file' => 'file2', 'path' => 'path/another_dir');
 * 
 */



/*
 * ---------------------------------------------------------------
 * DEFAULT APPLICATION DIRECTORIES
 * ---------------------------------------------------------------
 * 
 * This will allow you to change the location of the application
 * directories for controllers, models and views
 * 
 */

$config['controllers']  = 'controllers';
$config['models']       = 'models';
$config['views']        = 'views';

/*
 * ---------------------------------------------------------------
 * DEFAULT ROUTE
 * ---------------------------------------------------------------
 * 
 * when the router doesnt find a controller it will run this one.
 * 
 */

$config['default_route'] = 'home';

/*
 * ---------------------------------------------------------------
 * ROUTES
 * ---------------------------------------------------------------
 * 
 * These settings will override the usual method for loading a 
 * controller and methods.
 * 
 * Example:
 * 
 * You have a controller called blog accessing www.example.com/blog
 * would load the blog controller. But if you wanted the url to read 
 * www.example.com/news to access blog entries you would set the route
 * like this
 * 
 * $config['route']['news'] = 'blog'; 
 * 
 * WARNING: Naming a route the same as a controller name will override
 * the controller and the controller will no longer function unless
 * a seperate route is defined
 * 
 */

$config['route']['test'] = 'home';
$config['route']['index'] = 'home';

/*
 * ---------------------------------------------------------------
 * DATABASE SETTINGS
 * ---------------------------------------------------------------
 * 
 * Database connection settings: host, database name, username and password
 * 
 */

$config['dbhost']       = 'localhost';
$config['dbname']       = 'diditmed_fw';
$config['dbuser']       = 'root';
$config['dbpass']       = '';

$config['dsn']          = 'mysql: host='.$config['dbhost'].';dbname='.$config['dbname'].';';

?>
