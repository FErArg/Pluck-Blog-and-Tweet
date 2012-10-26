<?php
//This is a module for pluck, an opensource content management system
//Website: http://www.pluck-cms.org

//Make sure the file isn't accessed directly.
if((!ereg('index.php', $_SERVER['SCRIPT_FILENAME'])) && (!ereg('admin.php', $_SERVER['SCRIPT_FILENAME'])) && (!ereg('install.php', $_SERVER['SCRIPT_FILENAME'])) && (!ereg('login.php', $_SERVER['SCRIPT_FILENAME']))){
    //Give out an "access denied" error.
    echo 'access denied';
    //Block all other code.
    exit();
}

$includepage = 'blog_include.php';
$module_page['blog_viewcat'] = "View blog category";
$module_page['viewallposts'] = "View all posts";
$module_page['pagination'] = "Pagination view";

//Only set 'view post'-page if a post has been specified
if (isset($_GET['post'])) {
	//Check if post exists, and include information
	if (file_exists('data/settings/modules/blog/posts/'.$_GET['post'])) {
		include('data/settings/modules/blog/posts/'.$_GET['post']);
		$module_page['viewpost'] = $post_title;
	}
}
?>