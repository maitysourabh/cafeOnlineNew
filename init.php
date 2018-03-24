<?php
session_start();
include_once('admin/includes/config.php');
include_once('admin/includes/dbconnection.php');
include_once('admin/includes/database_tables.php');
include_once('admin/includes/common_function.php');
$link = Db_Connect();
if(!$link)
{
	exit;
}
$split_page_path = explode('/', $_SERVER['PHP_SELF']);
$page_name = end($split_page_path);

$admin_details = find('first', MASTER_ADMIN, 'email_address', "WHERE id = 1", array());
$site_setting = find('first', SETTINGS, 'open_close', "WHERE id = 1", array());

/*if(isset($_GET['ln']) && $_GET['ln']=='en'){
	$_SESSION['LANGUAGE'] = 'EN';
}else if(isset($_GET['ln']) && $_GET['ln']=='de'){
	$_SESSION['LANGUAGE'] = 'DE';
}else if(isset($_SESSION['LANGUAGE']) && $_SESSION['LANGUAGE']=='EN'){
	$_SESSION['LANGUAGE'] = 'EN';
}else if(isset($_SESSION['LANGUAGE']) && $_SESSION['LANGUAGE']=='DE'){
	$_SESSION['LANGUAGE'] = 'DE';
}else{
	$_SESSION['LANGUAGE'] = 'EN';
}
*/
?>