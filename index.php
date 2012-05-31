<?php

/**
 * ----------------------------------------------------------------------------
 * DIDITWORKS PHP FRAMEWORK
 * ----------------------------------------------------------------------------
 * 
 * A boilerplate PHP MVC Framework
 * 
 * @package diditworks
 * @author Paul Mulgrew <paul@diditmedia.com> 
 * @version 0.3
 */
//-----------------------------------------------------------------------------

/*
 * ----------------------------------------------------------------------------
 * ENVIRONMENT
 * ----------------------------------------------------------------------------
 * 
 * Set the environment level
 * Options: DEV     - Development
 *          PROD    - Production
 *          TEST    - Testing
 * 
 */

define('ENV', 'DEV');

/*
 * ----------------------------------------------------------------------------
 * LOGGING
 * ----------------------------------------------------------------------------
 * 
 * Define the logging level
 * 
 * options: 0    - Do not log anything
 *          1    - Log only errors
 *          2    - Log errors and database transactions
 *          3    - Log errors, database transactions and debugging
 *          4    - Log everything
 * 
 * 
 * 
 */

define('LOG', '0');


/*
 * ----------------------------------------------------------------------------
 * ERROR REPORTING
 * ----------------------------------------------------------------------------
 * 
 * Set Error reporting based in environmant setting
 * 
 * defaults to PROD settings. This way if an invalid setting is 
 * set errors will not show on a production site
 */

if(defined('ENV'))
{
        switch(ENV)
        {
                case 'DEV':
                        error_reporting(E_ALL);
                        break;

                CASE 'TEST':
                        error_reporting(E_ERROR | E_PARSE | E_STRICT);
                        break;

                case 'PROD':
                        error_reporting(0);
                        break;

                default :
                        error_reporting(0);
                        break;
        }
} else
{
        exit('Environment setting has not been defined. Please set ENV in root index.php file');
}

/*
 * -----------------------------------------------------------------------------
 * DIRECTORY SETTINGS
 * -----------------------------------------------------------------------------
 * 
 * Here we will set definitions for the following directories:
 * 
 *      Root            - Folder the application is installed on
 *      Application     - User created controllers, models, views etc.
 *      Public HTML     - CSS, Images, JS directories etc.
 *      System          - The main system folder where core application files are
 * 
 */


//check for https://
//and set referrer accordingly
if(isset($_SERVER['HTTPS']))
{
        define('REF', 'https://');
} else
{
        define('REF', 'http://');
}

//define director seperator
define('SEP', DIRECTORY_SEPARATOR);

//define extension 
define('EXT', '.php');

//define the root folder
//if the application is installed in the root directory leave this blank
define('ROOT', 'diditworks');

//define application folder
define('APPLICATION', 'application');

//define system folder
define('SYSTEM', 'system');

//define public HTML folder
define('PUBLIC_HTML', 'public_html');

/*
 * --------------------------------------------------------------------------------
 * DEFINE PATHS
 * --------------------------------------------------------------------------------
 * 
 * Using the defined directories now we define paths to them.
 */

//define main index file
define('INDEX', pathinfo(__FILE__, PATHINFO_BASENAME));

define('BASEPATH', str_replace(INDEX, '', __FILE__));

//define baseurl
define('BASEURL', REF . $_SERVER['SERVER_NAME'] . '/' . ROOT);

//define application path
define('APP_PATH', realpath(APPLICATION));

//define system path
define('SYS_PATH', realpath(SYSTEM));

//define public HTML path
define('PUB_PATH', realpath(PUBLIC_HTML));

//define the url to the public html folder
define('PUB_URL', BASEURL.SEP.PUBLIC_HTML);




/*
 * Now we check if the directories configured are valid
 */

foreach(array( APPLICATION, SYSTEM, PUBLIC_HTML ) as $dir)
{
        if(!is_dir($dir))
        {
                exit($dir . ' is not a valid directory');
        }
}

/*
 * -----------------------------------------------------------------------
 * LOAD BOOTSTRAP
 * -----------------------------------------------------------------------
 * 
 * The boostrap will load the rest of the application
 * 
 */

//check if the bootstrap file exists
if(file_exists(SYS_PATH . SEP . 'core' . SEP . 'bootstrap.php'))
{
        require SYS_PATH . SEP . 'core' . SEP . 'bootstrap.php';
} else
{
        exit('The bootstrap file is missing');
}

