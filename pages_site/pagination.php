<?php
/*
 * This file is part of pluck, the easy content management system
 * Copyright (c) somp (www.somp.nl)
 * http://www.pluck-cms.org

 * Pluck is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * See docs/COPYING for the complete license.
*/

//Make sure the file isn't accessed directly
if((!ereg("index.php", $_SERVER['SCRIPT_FILENAME'])) && (!ereg("admin.php", $_SERVER['SCRIPT_FILENAME'])) && (!ereg("install.php", $_SERVER['SCRIPT_FILENAME'])) && (!ereg("login.php", $_SERVER['SCRIPT_FILENAME']))){
    //Give out an "access denied" error
    echo "access denied";
    //Block all other code
    exit();
}
include("data/modules/blog/functions.php");

if (file_exists("data/settings/blog.php"))
	include("data/settings/blog.php");

//for pagination
$i = 1;
$pagin = $_GET['pagin'];

//Display existing posts, but only if post-index file exists
if (file_exists('data/settings/modules/blog/post_index.dat')) {
	$handle = fopen('data/settings/modules/blog/post_index.dat', 'r');
	while (!feof($handle)) {
		$file = fgets($handle, 4096);
		//Filter out line breaks
		$file = str_replace ("\n",'', $file);
		//Check if post exists
		if ((file_exists('data/settings/modules/blog/posts/'.$file)) && (is_file('data/settings/modules/blog/posts/'.$file))) {
		
if ($pagination == 'on') {
	if ($i > (($pagin * $nmb_posts)-$nmb_posts) && $i <= ($pagin * $nmb_posts)) {

			//Include post information for showing
			include_once('data/settings/modules/blog/posts/'.$file);
			
			
			
			?>
			<div class="blogpost" style="margin-top: 20px">
				<span class="posttitle" style="font-size: 18px;">
					<a href="?module=blog&amp;page=viewpost&amp;post=<?php echo $file; ?>&amp;pageback=<?php echo $current_page_filename; ?>"><?php echo $post_title; ?></a>
				</span><br />
				<span class="postinfo" style="font-size: 10px;">
					<?php echo $lang_blog14; ?> <span style="font-weight: bold;"><a href="?module=blog&page=blog_viewcat&var1=<?php echo $post_category; ?>"><?php echo $post_category; ?></a></span> - <?php echo $post_month; ?>-<?php echo $post_day; ?>-<?php echo $post_year; ?>, <?php echo $post_time; ?>
				</span>
				<br /><br />
				<?php
				if ($short_post == 'on')
					echo cutString($post_content,128);
				else
					echo $post_content;
				?>
				<p>
					<a href="?module=blog&amp;page=viewpost&amp;post=<?php echo $file; ?>&amp;pageback=<?php echo $current_page_filename; ?>">&raquo; ver mas</a>
				</p>
			</div>
			<?php

	}

}
		}//file exist
	//next number of post
	$i++;
	}
	//Close module-dir
	fclose($handle);

	if ($pagination == 'on') {
	$prev = $pagin - 1;
	$next = $pagin + 1;
	$files = read_dir_contents('data/settings/modules/blog/posts','files');
	$files = count($files);
	
		//start
		echo '<p>'."\n";
		if ($prev == 0)
			echo '<p><a href="?module=blog&amp;page=pagination&amp;pagin='.$next.'">Página Siguiente</a></p>';
		else			
			echo '<a href="?module=blog&amp;page=pagination&amp;pagin='.$prev.'">Página Anterior</a>';

		//middle
		echo ' | ';

		//last
		if ($files > ($pagin * $nmb_posts))
			echo '<a href="?module=blog&amp;page=pagination&amp;pagin='.$next.'">Página Siguiente</a>';

		//end
		echo '</p>';
		echo '<p>'."\n"
			.'<a href="?module=blog&amp;page=viewallposts">Ver todos los Posts</a>'."\n"
		.'</p>';
	}
	else
		echo 'error';
}
?>
