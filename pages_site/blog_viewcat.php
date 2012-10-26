<?php

$var1 = $_GET['var1'];

if (file_exists('data/settings/modules/blog/posts')) {
	$files = read_dir_contents('data/settings/modules/blog/posts','files');
	foreach ($files as $file) {
	include 'data/settings/modules/blog/posts/'.$file;
		if ($var1 == $post_category) {
		echo "<p><a href=\"?module=blog&page=viewpost&post=$file\">$post_title</a></p>";
		}
	}
}
?>