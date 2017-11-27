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
	$link_icon = array(
		'href'  => $materialize_URL . '/images/icons/favicon.ico',
		'rel'   => 'icon',
		'type'  => 'image/x-icon'
	);

	$link_fa = array(
		'href'  => $materialize_URL . '/css/font-awesome.min.css',
		'rel'   => 'stylesheet',
		'type'  => 'text/css'
	);

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
	echo link_tag($link_fa);
	echo link_tag($link_icon);
	echo link_tag($link_material);
	echo link_tag($link_main_style);

	$meta = array(
		'name' 		=> 'viewport',
		'content' 	=> 'width=device-width, initial-scale=1.0'
	);

	if (isset($include_files['css'])) {
		for ($i=0; $i < count($include_files['css']); $i++) {
			$current_index = $include_files['css'][$i];
			for ($x = 0; $x < count($current_index['files']); $x++) {
				$link_extra = array(
					'href'	=>	$materialize_URL . '/' . $current_index['folder'] . '/' . $current_index['files'][$i] . '.css',
					'rel'   => 'stylesheet',
					'type'  => 'text/css',
					'media' => 'screen,projection'
				);
				echo link_tag($link_extra);
			}
		}
	}

	echo meta($meta);
?>

</head>
<body class="<?php echo $this->page_actions->page_body_class(); ?>">