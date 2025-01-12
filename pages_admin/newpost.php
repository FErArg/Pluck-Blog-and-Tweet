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

 * SerInformaticos
*/

//Make sure the file isn't accessed directly
if((!ereg("index.php", $_SERVER['SCRIPT_FILENAME'])) && (!ereg("admin.php", $_SERVER['SCRIPT_FILENAME'])) && (!ereg("install.php", $_SERVER['SCRIPT_FILENAME'])) && (!ereg("login.php", $_SERVER['SCRIPT_FILENAME']))){
    //Give out an "access denied" error
    echo "access denied";
    //Block all other code
    exit();
}

//Include functions
include('data/modules/blog/functions.php');
?>

<div class="rightmenu">
<?php echo $lang_page8; ?><br />
<?php
//Generate the menu on the right
read_imagesinpages('images');
?>
</div>

<form method="post" action="">
	<span class="kop2"><?php echo $lang_install17; ?></span><br />
	<input name="cont1" type="text" value=""><br /><br />

	<span class="kop2"><?php echo $lang_blog26; ?></span><br />
	<select name="cont2">
		<option value="<?php echo $lang_blog27; ?>" /> <?php echo $lang_blog25; ?>
<?php
//If there are categories
if(file_exists('data/settings/modules/blog/categories.dat')) {
	//Load them
	$categories = file_get_contents('data/settings/modules/blog/categories.dat');

	//Then in an array
	$categories = split(',',$categories);

	//And show them
	//start table first
	foreach($categories as $key => $name) {
		echo '<option value="'.$name.'" />'.$name;
	}
}
?>
	</select><br /><br />

	<span class="kop2"><?php echo $lang_install18; ?></span><br />
	<textarea class="tinymce" name="cont3" cols="70" rows="20"></textarea><br />

	<input type="submit" name="Submit" value="<?php echo $lang_install13; ?>">
	<input type="button" name="Cancel" value="<?php echo $lang_install14; ?>" onclick="javascript: window.location='?module=blog';">
</form>

<?php
//If form is posted...
if(isset($_POST['Submit'])) {

	//Strip slashes
	$cont1 = stripslashes($cont1);
	$cont1 = str_replace("\"", "\\\"", $cont1);
	$cont2 = stripslashes($cont2);
	$cont2 = str_replace("\"", "\\\"", $cont2);
	$cont3 = stripslashes($cont3);
	$cont3 = str_replace("\"", "\\\"", $cont3);

	//Determine the date
	$day = date("d");
	$month = date("m");
	$year = date("Y");
	$time = date("H:i");

	//Check if 'posts' directory exists, if not; create it
	if(!file_exists('data/settings/modules/blog/posts')) {
		mkdir('data/settings/modules/blog/posts',0777);
		chmod('data/settings/modules/blog/posts',0777);
	}

	//Generate filename
	$newfile = strtolower($cont1);
	$newfile = str_replace('.','',$newfile);
	$newfile = str_replace(',','',$newfile);
	$newfile = str_replace('?','',$newfile);
	$newfile = str_replace(':','',$newfile);
	$newfile = str_replace('<','',$newfile);
	$newfile = str_replace('>','',$newfile);
	$newfile = str_replace('=','',$newfile);
	$newfile = str_replace('"','',$newfile);
	$newfile = str_replace('\'','',$newfile);
	$newfile = str_replace('/','',$newfile);
	$newfile = str_replace("\\",'',$newfile);
	$newfile = str_replace('  ','-',$newfile);
	$newfile = str_replace(' ','-',$newfile);
	$newfile = str_replace('ñ','n',$newfile);
	$newfile = str_replace('Ñ','N',$newfile);
	$newfile = str_replace('á','a',$newfile);
	$newfile = str_replace('é','e',$newfile);
	$newfile = str_replace('í','i',$newfile);
	$newfile = str_replace('ó','o',$newfile);
	$newfile = str_replace('ú','u',$newfile);
	$newfile = str_replace('Á','A',$newfile);
	$newfile = str_replace('É','E',$newfile);
	$newfile = str_replace('Í','I',$newfile);
	$newfile = str_replace('Ó','O',$newfile);
	$newfile = str_replace('Ú','U',$newfile);
	$newfile = str_replace('&','y',$newfile);


	//Make sure chosen filename doesn't exist
	if(file_exists('data/settings/modules/blog/posts/'.$newfile.'.php')) {
		$newfile = $newfile.'-new';
	}

	//Create/update the post_index.dat file
	if(file_exists('data/settings/modules/blog/post_index.dat')) {
		$contents = file_get_contents('data/settings/modules/blog/post_index.dat');
		$file = fopen('data/settings/modules/blog/post_index.dat', 'w');
		if(!empty($contents)) {
			fputs($file,$newfile.'.php'."\n".$contents);
		}
		else {
			fputs($file,$newfile.'.php');
		}
	}
	else {
		$file = fopen('data/settings/modules/blog/post_index.dat', 'w');
		fputs($file,$newfile.'.php');
	}
	fclose($file);
	unset($file);
	chmod('data/settings/modules/blog/post_index.dat', 0777);

	//Save information
	$file = fopen('data/settings/modules/blog/posts/'.$newfile.'.php', 'w');
	fputs($file, '<?php'."\n"
	.'$post_title = "'.$cont1.'";'."\n"
	.'$post_category = "'.$cont2.'";'."\n"
	.'$post_content = "'.$cont3.'";'."\n"
	.'$post_day = "'.$day.'";'."\n"
	.'$post_month = "'.$month.'";'."\n"
	.'$post_year = "'.$year.'";'."\n"
	.'$post_time = "'.$time.'";'."\n"
	.'?>');
	fclose($file);
	chmod('data/settings/modules/blog/posts/'.$newfile.'.php',0777);

	/* Envia titulo, link y categoría a twitter
	 * Sent to twitter Title, Link and Category
	 * Desarrollado por SerInformatiocs
	 * Developed by SerInformaticos
	 * info@SerInformaticos.es
	 * www.SerInformaticos.es
	 */
	$dominio = $_SERVER['SERVER_NAME'];
	$url = "http://".$dominio."/?module=blog&page=viewpost&post=".$newfile.".php";
	$titulo = $cont1;
	$categoria = $cont2;

	$t = $titulo." ".$url." #".$categoria;
	$t = str_replace('http://','', $t);

	include('pv-auto-tweets/pv-auto-tweets.php');
	$tweet->post('statuses/update', array('status' => $t));

	$respuesta = $tweet->http_code;

	if( $respuesta != '200' ){
		echo "<h1>Error Twitting</h1><br />\n";
		redirect('?module=blog','2');
	} else{
		echo "<h1>Twitted</h1><br />\n";
		redirect('?module=blog','2');
	}

}
?>
