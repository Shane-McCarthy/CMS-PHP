<?php
/**
 * Created by PhpStorm.
 * User: can you dig it
 * Date: 1/14/14
 * Time: 7:52 PM
 */
//define the core paths
// Define them as absolute paths to make sure that require once works as expected


defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
defined('SITE_ROOT') ? null :
//arivix path
    //define('SITE_ROOT',DS.'HostingSpaces'.DS.'ssd19morgan'.DS.'widerfunnelbuild.mbwillow.com'.DS.'wwwroot');
//local host path
    define('SITE_ROOT','./../../');
//C:\wamp\www\Widerfunnel\widerfunnelcentral

defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT . 'includes');
// load config file first
require_once(LIB_PATH . "/config.php");
// load basic function next so everything can use them
require_once(LIB_PATH ."/functions.php");
// load core objects
require_once(LIB_PATH . "/session.php");
require_once(LIB_PATH . "/database.php");
require_once(LIB_PATH .  "/database_object.php");
require_once(LIB_PATH .  "/pagination.php");

// load database related classes
require_once(LIB_PATH .  "/user.php");
require_once(LIB_PATH . "/funex.php");
require_once(LIB_PATH . "/links.php");
require_once(LIB_PATH . "/client.php");
require_once(LIB_PATH .  "/screenshots.php");
require_once(LIB_PATH . "/optimizely_screens.php");
require_once(LIB_PATH . "/exp_no.php");
require_once(LIB_PATH .  "/pages.php");
//require_once(LIB_PATH.DS."comment.php");