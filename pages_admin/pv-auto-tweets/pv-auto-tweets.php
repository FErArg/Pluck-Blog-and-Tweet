<?php
/* Esta ainformación la provee Twitter
 * Information provided by Twitter
 */
$consumerKey    = '';
$consumerSecret = '';
$oAuthToken     = '';
$oAuthSecret    = '';

# API OAuth
require_once('twitteroauth.php');

$tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);

# your code to retrieve data goes here, you can fetch your data from a rss feed or database

/* Ejemplo de uso
 * Example of use
$tweet->post('statuses/update', array('status' => 'Text to Tweet'));
*/
?>
