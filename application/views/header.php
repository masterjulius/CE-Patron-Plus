<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$materialize_URL = base_url( '/third_party/materialize' );
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo isset($page_title) ? $page_title : 'CE Patron Plus'; ?></title>

<?php

	$link_material = array(
		'href'  => $materialize_URL . '/css/materialize.min.css',
		'rel'   => 'stylesheet',
		'type'  => 'text/css',
		'media' => 'screen,projection'
	);

	$link_main_style = array(
		'href'  => $materialize_URL . '/css/style.min.css',
		'rel'   => 'stylesheet',
		'type'  => 'text/css',
		'media' => 'screen,projection'
	);
	echo link_tag($link_material);
	echo link_tag($link_main_style);

	$meta = array(
		'name' 		=> 'viewport',
		'content' 	=> 'width=device-width, initial-scale=1.0'
	);
	echo meta($meta);
?>

	<script src="<?php echo $materialize_URL; ?>/js/jquery-3.2.1.min.js" type="text/javascript"></script>
    <script src="<?php echo $materialize_URL; ?>/js/materialize.min.js" type="text/javascript"></script>
    <script src="<?php echo $materialize_URL; ?>/js/main.js" type="text/javascript"></script>

</head>
<body class="<?php echo $this->page_actions->page_body_class(); ?>">