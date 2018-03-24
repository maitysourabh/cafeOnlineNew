<?php

/*
=========================================================================================================================
COPYRIGHT: SITE NAME
PRODUCT NAME: PROJECT NAME
PAGE NAME: CONFIG.PHP
PAGE FUNCTIONALITY: CONSISTS OF WEBSITE GENERAL AND OVERALL CONFIGURATION SETTINGS AND DEFINATION OF CONSTANTS AND GLOBAL VARIABLES USED THROUGHOUT THE WEBSITE.
=========================================================================================================================
*/
error_reporting(1);
//ENTER THE NAME OF THE DATABASE SERVER YOU ARE CONNECTING TO. NORMALLY SET TO "localhost"
define("DATABASE_SERVER", "localhost");

//ENTER THE NAME OF YOUR DATABASE
define("DATABASE_NAME", "cafe_cafeonline1");
//LIVE
//define("DATABASE_NAME", "thehavan_cafeonline");

//ENTER THE USERNAME THAT CONNECTS TO YOUR DATABASE
define("DATABASE_USERNAME", "root");
//LIVE
//define("DATABASE_USERNAME", "cafe_cafeon2");

//ENTER THE PASSWORD FOR YOUR DATABASE USER
//define("DATABASE_PASSWORD", "cafe43215@");
define("DATABASE_PASSWORD", "");
//LIVE
//define("DATABASE_PASSWORD", "@V+?iF7nS3?!");
define( "ADMIN_TITLE", 'Restaurant Administration Panel' );


//ENTER THE DOMAIN NAME FOR YOUR APPLICATION
//define("DOMAIN_NAME_PATH", "http://localhost/singhs/");
//LIVE
define("DOMAIN_NAME_PATH", "http://indianrestaurantadelaide.com/");

//ENTER THE ADMIN PATH FOR YOUR APPLICATION
//define("DOMAIN_NAME_PATH_ADMIN", "http://localhost/singhs/admin/");
//LIVE
define("DOMAIN_NAME_PATH_ADMIN", "http://indianrestaurantadelaide.com/admin/");

//DEFINE PAGINATION LIMIT OF LISTING PAGE
define("PAGELIMIT", "25");

//TIME ZONE FOR GERMAN
date_default_timezone_set('Australia/Sydney');
/*******************SET 24 horus ****************/
define( "CURRENT_HOURS", date('Hi') );
define( "START_MORNING_HOURS", "1130" );//11:30
define( "END_MORNING_HOURS", "1345" );//13:45

define( "MORNING_MENU_TYPE", 'Mittagsmen&uuml;' );
define( "LUNCH_MENU_TYPE_REGEXP", 'Mittagsmen&uuml;|Lunch' );//REGULAR EXPRETION FOR ON CODITION(Type Devide by | (i.e example1|exmple2)) 

define( "SITE_CURRENCY", '&#36;' );
define( "FRONT_TITLE", 'Cafe Tandoor' );
?>