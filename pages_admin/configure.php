<?php
//Make sure the file isn't accessed directly
if((!ereg("index.php", $_SERVER['SCRIPT_FILENAME'])) && (!ereg("admin.php", $_SERVER['SCRIPT_FILENAME'])) && (!ereg("install.php", $_SERVER['SCRIPT_FILENAME'])) && (!ereg("login.php", $_SERVER['SCRIPT_FILENAME']))){
    //Give out an "access denied" error
    echo "access denied";
    //Block all other code
    exit();
}

//Include functions
include('data/modules/blog/functions.php');

//Lang
global $lang_theme12, $lang_install13, $lang_lang2;

//Configuration
if (file_exists('data/settings/blog.php'))
	include_once('data/settings/blog.php');
else {
	$nmb_posts = 0;
	$short_post = 'false';
	$pagination = 'false';
}

?>
	<form method="post" action="">
		<label class="kop2" for="cont1"><?php echo 'numbers of posts'; ?></label>
		<br />
		<select name="cont1" id="cont1">
			<option value=""><?php echo $lang_lang2; ?></option>
			<?php
			for ($i=0; $i <= 10; $i++)
				if ($nmb_posts == $i)
					echo '<option value="'.$i.'" selected>'.$i.'</option>';
				else
					echo '<option value="'.$i.'">'.$i.'</option>';
			?>
		</select>
		<br/>
		<input name="cont2" id="cont2" type="checkbox" <?php if ($short_post == 'on') echo 'checked="checked"'; ?> /> <label class="kop2" for="cont2"><?php echo 'show short posts'; ?></label>
		<br/>
		<input name="cont3" id="cont3" type="checkbox" <?php if ($pagination == 'on') echo 'checked="checked"'; ?> /> <label class="kop2" for="cont3"><?php echo 'show blog pagination'; ?></label>
		<br />
		
		<input type="submit" name="Submit" value="<?php echo $lang_install13; ?>" />
	</form>
	<?php
	//If form is posted...
	if (isset($_POST['Submit'])) {

		if (!empty($cont1)) {
			if (!isset($cont2))
				$cont2 = 'false';
			if (!isset($cont3))
				$cont3 = 'false';
			
			$err = blog_config_save($cont1, $cont2, $cont3);
			
			redirect('?module=blog', 0);
		}
		else
			echo 'error';
	}
	
?>
<br />
<p>
		<a href="?module=blog">&lt;&lt;&lt; <?php echo $lang_theme12; ?></a>
</p>
