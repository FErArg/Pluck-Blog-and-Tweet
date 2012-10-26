<?php
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

//Display existing posts, but only if post-index file exists
if (file_exists('data/settings/modules/blog/post_index.dat')) {
	$handle = fopen('data/settings/modules/blog/post_index.dat', 'r');
	while (!feof($handle)) {
		$file = fgets($handle, 4096);
		//Filter out line breaks
		$file = str_replace ("\n",'', $file);
		//Check if post exists
		if ((file_exists('data/settings/modules/blog/posts/'.$file)) && (is_file('data/settings/modules/blog/posts/'.$file))) {

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
					<a href="?module=blog&amp;page=viewpost&amp;post=<?php echo $file; ?>&amp;pageback=<?php echo $current_page_filename; ?>">&raquo; <?php echo $lang_blog23; ?></a>
				</p>
			</div>
			<?php
		}//file exist
	
	}
	//Close module-dir
	fclose($handle);
}
?>