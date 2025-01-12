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

//Predefined variable
$post = $_GET['post'];
$pageback = $_GET['pageback'];
?>

<div class="blogpost">
	<span class="postinfo" style="font-size: 10px;">
		<?php echo $lang_blog14; ?> <span style="font-weight: bold;"><?php echo $post_category; ?></span> - <?php echo $post_month; ?>-<?php echo $post_day; ?>-<?php echo $post_year; ?>, <?php echo $post_time; ?>
	</span><br /><br />
	<?php echo $post_content; ?>
				<!-- Boton ShareThis -->
				<span class="st_email"></span><span class="st_facebook"></span><span class="st_twitter"></span><span class="st_sharethis" displayText="ShareThis"></span>
</div>



<?php
//If form is posted...
if(isset($_POST['Submit'])) {

	//Check if everything has been filled in
	if((!isset($_POST['title'])) || (!isset($_POST['name'])) || (!isset($_POST['message']))) { ?>
		<span style="color: red;"><?php echo $lang_contact6; ?></span>
	<?php
		exit;
	}

	else {
		//Then fetch our posted variables
		$title = $_POST['title'];
		$name = $_POST['name'];
		$message = $_POST['message'];

		//Check for HTML, and eventually block it
		if ((ereg('<', $title)) || (ereg('>', $title)) || (ereg('<', $name)) || (ereg('>', $name)) || (ereg('<', $message)) || (ereg('>', $message))) { ?>
			<span style="color: red;"><?php echo $lang_blog22; ?></span>
		<?php }

		//If no HTML is present
		else {
			//Delete unwanted characters
			$title = stripslashes($title);
			$title = str_replace('"', '', $title);
			$name = stripslashes($name);
			$name = str_replace('"', '', $name);
			$message = stripslashes($message);
			$message = str_replace('"', '', $message);
			$message = str_replace("\n", '<br />', $message);

			//Strip slashes from post itself too
			$post_title = stripslashes($post_title);
			$post_title = str_replace("\"", "\\\"", $post_title);
			$post_category = stripslashes($post_category);
			$post_category = str_replace("\"", "\\\"", $post_category);
			$post_content = stripslashes($post_content);
			$post_content = str_replace("\"", "\\\"", $post_content);

			//Determine the date
			$day = date("d");
			$month = date("m");
			$year = date("Y");
			$time = date("H:i");

			//Then, save existing post information
			$file = fopen('data/settings/modules/blog/posts/'.$post, 'w');
			fputs($file, '<?php'."\n"
			.'$post_title = "'.$post_title.'";'."\n"
			.'$post_category = "'.$post_category.'";'."\n"
			.'$post_content = "'.$post_content.'";'."\n"
			.'$post_day = "'.$post_day.'";'."\n"
			.'$post_month = "'.$post_month.'";'."\n"
			.'$post_year = "'.$post_year.'";'."\n"
			.'$post_time = "'.$post_time.'";'."\n");

			//Check if there already are other reactions
			if(isset($post_reaction_title)) {
				foreach($post_reaction_title as $reaction_key => $value) {
					//Set key
					$key = $reaction_key + 1;
					//And save the existing reaction
					fputs($file, '$post_reaction_title['.$reaction_key.'] = "'.$post_reaction_title[$reaction_key].'";'."\n"
					.'$post_reaction_name['.$reaction_key.'] = "'.$post_reaction_name[$reaction_key].'";'."\n"
					.'$post_reaction_content['.$reaction_key.'] = "'.$post_reaction_content[$reaction_key].'";'."\n"
					.'$post_reaction_day['.$reaction_key.'] = "'.$post_reaction_day[$reaction_key].'";'."\n"
					.'$post_reaction_month['.$reaction_key.'] = "'.$post_reaction_month[$reaction_key].'";'."\n"
					.'$post_reaction_year['.$reaction_key.'] = "'.$post_reaction_year[$reaction_key].'";'."\n"
					.'$post_reaction_time['.$reaction_key.'] = "'.$post_reaction_time[$reaction_key].'";'."\n");
				}
			}		

			//If this is the first reaction, use key '0'
			else {
				$key = 0;
			}

			//Then, save reaction
			fputs($file, '$post_reaction_title['.$key.'] = "'.$title.'";'."\n"
			.'$post_reaction_name['.$key.'] = "'.$name.'";'."\n"
			.'$post_reaction_content['.$key.'] = "'.$message.'";'."\n"
			.'$post_reaction_day['.$key.'] = "'.$day.'";'."\n"
			.'$post_reaction_month['.$key.'] = "'.$month.'";'."\n"
			.'$post_reaction_year['.$key.'] = "'.$year.'";'."\n"
			.'$post_reaction_time['.$key.'] = "'.$time.'";'."\n"
			.'?>');
			fclose($file);
			chmod('data/settings/modules/blog/posts/'.$post,0777);
			$subject = "$lang_contact7 $name";
			mail($email,$subject,"<html><body>$message</body></html>","From: $email \n" . "Content-type: text/html; charset=utf-8");
			//Redirect user
			redirect('?module=blog&page=viewpost&post='.$post.'&pageback='.$pageback,'0');
		}
	}
}
?>

<p><a href="?file=<?php echo $pageback; ?>">&lt;&lt;&lt; <?php echo $lang_theme12; ?></a></p>
