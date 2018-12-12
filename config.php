<?php
/*
config.php
stores configuration information for our web application
*/
//removes header already sent errors
ob_start();
define('SECURE',false); #force secure, https, for all site pages
define('PREFIX', 'widgets_fl18_'); #Adds uniqueness to your DB table names.  Limits hackability, naming collisions
header("Cache-Control: no-cache");header("Expires: -1");#Helps stop browser & proxy caching
define('DEBUG',true); #we want to see all errors
include 'credentials.php';//stores database info
include 'common.php';//stores favorite functions
//prevents date errors
date_default_timezone_set('America/Los_Angeles');
//create config object
$config = new stdClass;
//CHANGE TO MATCH YOUR PAGES
//here are the urls and page names for our main nav
$config->nav1['index.php']='Home';
$config->nav1['order.php']='Order';
$config->nav1['daily.php']='Daily Specials';
$config->nav1['cheese_list.php']='Our Cheeses';
$config->nav1['contact.php']='Contact Us';
//create default page identifier
define('THIS_PAGE',basename($_SERVER['PHP_SELF']));
//START NEW THEME STUFF - be sure to add trailing slash!
$sub_folder = 'itc240/mywidgets/';//change to 'widgets' or 'sprockets' etc.
$config->theme = 'Green';//sub folder to themes
//will add sub-folder if not loaded to root:
$config->physical_path = $_SERVER["DOCUMENT_ROOT"] . '/' . $sub_folder;
//force secure website
if (SECURE && $_SERVER['SERVER_PORT'] != 443) {#force HTTPS
	header("Location: https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
}else{
    //adjust protocol
    $protocol = (SECURE==true ? 'https://' : 'http://'); // returns true
    
}
$config->virtual_path = $protocol . $_SERVER["HTTP_HOST"] . '/' . $sub_folder;
define('ADMIN_PATH', $config->virtual_path . 'admin/'); # Could change to sub folder
define('INCLUDE_PATH', $config->physical_path . 'includes/');
//CHANGE ITEMS BELOW TO MATCH YOUR SHORT TAGS
//default page values
$config->title = THIS_PAGE;
$config->siteName = 'Yummy Cheese Shop';
$config->slogan = 'All the cheese you could ever want';
$config->pageHeader = 'Yummy Cheese';
switch(THIS_PAGE){
 case'index.php':
        $config->title = 'Index Page';
        $config->pageHeader = 'Satisfying all your cheese needs!';
        break;
 
    case'order.php':
        $config->title = 'Order Page';
        $config->pageHeader = 'We do cheese plates for parties!';
        break;        
        
    case'daily.php':
        $config->title = 'Daily Specials';
        $config->pageHeader = 'See all our daily specials!';
        break;        
        
    case'contact.php':
        $config->title = 'Contact Us';
        $config->pageHeader = 'Please contact us with any questions';
        break;   
        
    case'customer_list.php':
        $config->title = 'Our Cheeses';
        $config->pageHeader = 'Our current roster of yummy cheeses!';
        break;             
}
/*
makeLinks() will create navigation items from an array
*/
function makeLinks($nav)
{
    $myReturn = '';
    
    foreach($nav as $key => $value){
     
    $url = $config->virtual_path . $key;
    $myReturn .= '<a href="' . $url . '">' . $value .  '</a>';
    }
    
    return $myReturn;
} //end makeLinks
//creates theme virtual path for theme assets, JS, CSS, images
$config->theme_virtual = $config->virtual_path . 'themes/' . $config->theme . '/';
/*
 * adminWidget allows clients to get to admin page from anywhere
 * code will show/hide based on logged in status
*/
/*
 * adminWidget allows clients to get to admin page from anywhere
 * code will show/hide based on logged in status
*/
if(startSession() && isset($_SESSION['AdminID']))
{#add admin logged in info to sidebar or nav
    
    $config->adminWidget = '
        <a href="' . ADMIN_PATH . 'admin_dashboard.php">ADMIN</a> 
        <a href="' . ADMIN_PATH . 'admin_logout.php">LOGOUT</a>
    ';
}else{//show login (YOU MAY WANT TO SET TO EMPTY STRING FOR SECURITY)
    
    $config->adminWidget = '
        <a  href="' . ADMIN_PATH . 'admin_login.php">LOGIN</a>
    ';
}
?>
