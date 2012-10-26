<?php
//This is a module for pluck, an opensource content management system
//Website: http://www.pluck-cms.org

//MODULE NAME: blog
//DESCRIPTION: this module lets the user create an own blog
//LICENSE: GPLv3
//This module is included with pluck

//Make sure the file isn't accessed directly
if((!ereg("index.php", $_SERVER['SCRIPT_FILENAME'])) && (!ereg("admin.php", $_SERVER['SCRIPT_FILENAME'])) && (!ereg("install.php", $_SERVER['SCRIPT_FILENAME'])) && (!ereg("login.php", $_SERVER['SCRIPT_FILENAME']))){
    //Give out an "access denied" error
    echo "access denied";
    //Block all other code
    exit();
}

$startpage = 'blog.php';
$module_page['deletecategory'] = $lang_blog6;
$module_page['editreactions'] = $lang_blog19;
$module_page['deletereactions'] = $lang_blog21;
$module_page['editpost'] = $lang_blog11;
$module_page['deletepost'] = $lang_blog12;
$module_page['newpost'] = $lang_blog10;
$module_page['configure'] = 'Configuration';
?>
