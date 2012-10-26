<?php
//Make sure the file isn't accessed directly
if((!ereg("index.php", $_SERVER['SCRIPT_FILENAME'])) && (!ereg("admin.php", $_SERVER['SCRIPT_FILENAME'])) && (!ereg("install.php", $_SERVER['SCRIPT_FILENAME'])) && (!ereg("login.php", $_SERVER['SCRIPT_FILENAME']))){
    //Give out an "access denied" error
    echo "access denied";
    //Block all other code
    exit();
}

//Predefined variables
if (isset($_GET['var'])) {
	$var = $_GET['var'];
}
if (isset($_GET['var2'])) {
	$var2 = $_GET['var2'];
}
if (isset($_GET['var2'])) {
	$var3 = $_GET['var3'];
}


function cutString($txt,$x) {
$tlen = strlen($txt);
if($x < 1) return '';
if($x >= $tlen - 1) return $txt;
while ($txt{$x} != ' ' && ++$x < $tlen);
$new = substr($txt, 0, $x);
return $new.'...';
}

function blog_config_save($nmb_posts, $short_post, $pagination) {
	$data = '<?php'."\n"
		.'$nmb_posts = '.$nmb_posts.';'."\n"
		.'$short_post = \''.$short_post.'\';'."\n"
		.'$pagination = \''.$pagination.'\';'."\n"
		.'?>';

	file_put_contents('data/settings/blog.php', $data);
}
?>
