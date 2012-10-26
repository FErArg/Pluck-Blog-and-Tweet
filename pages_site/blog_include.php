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


	if ($i <= $nmb_posts) {
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
				<!-- Boton ShareThis -->
				<br />
				<br />
				<span class="st_email"></span><span class="st_facebook"></span><span class="st_twitter"></span><span class="st_sharethis" displayText="ShareThis"></span> 
				<br />
				<p>
					<a href="?module=blog&amp;page=viewpost&amp;post=<?php echo $file; ?>&amp;pageback=<?php echo $current_page_filename; ?>">&raquo; ver mas</a>
				</p>
			</div>
			<?php
	$i++;
	}
}
else {
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
				<!-- Boton ShareThis -->
				<span class="st_email"></span><span class="st_facebook"></span><span class="st_twitter"></span><span class="st_sharethis" displayText="ShareThis"></span> 
<br />
				<p>
					<a href="?module=blog&amp;page=viewpost&amp;post=<?php echo $file; ?>&amp;pageback=<?php echo $current_page_filename; ?>">&raquo; ver mas</a>
				</p>
			</div>
			<?php
}
		}//file exist
	
	}
	//Close module-dir
	fclose($handle);

	if ($pagination == 'on') {
		echo '<p>'."\n"
			.'<a href="?module=blog&amp;page=pagination&amp;pagin=2">Página Siguiente</a>'."\n"
		.'</p>';

		echo '<p>'."\n"
			.'<a href="?module=blog&amp;page=viewallposts">Ver todos los Posts</a>'."\n"
		.'</p>';
	}
}
?>
