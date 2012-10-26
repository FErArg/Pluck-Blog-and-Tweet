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


//Include language-items
include ("data/settings/langpref.php");
include ("data/inc/lang/en.php");
include ("data/inc/lang/$langpref");

//Module name
$module_name = 'blog & tweet';

//Short module introduction
$module_intro = 'usa un blog para publicar noticias o escribir post y twittearlo';

//Module dir
$module_dir = "blog";

//Filename of the module-icon
$module_icon = "images/blog.png";

//Version of the module
$module_version = "0.1.2";

//Author of the module
$module_author = "pluck development team & SerInformaticos";

//Website of the module
$module_website = "http://www.serinformaticos.es";

//We need TinyMCE!
$tinymce = "yes";

//Compatibility
$module_compatibility = "4.6";

?>
