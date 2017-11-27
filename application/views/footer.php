<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$materialize_URL = base_url( '/third_party/materialize' );
$materializeJS = $materialize_URL . '/js/materialize-custom.js';
?>
		<script src="<?php echo $materialize_URL; ?>/js/jquery-3.2.1.min.js" type="text/javascript"></script>
		<script src="<?php echo $materializeJS; ?>" type="text/javascript"></script>
		<script src="<?php echo $materialize_URL; ?>/js/main.js" type="text/javascript"></script>
<?php
	// if (isset($include_files['js'])) {
	// 	for ($i=0; $i < count($include_files['js']['files']); $i++) {
	// 		$script_src = $materialize_URL . '/' . $include_files['js']['folder'] . '/' . $include_files['js']['files'][$i] . '.js';
	// 		echo '<script src="' . $script_src . '" type="text/javascript"></script>';
	// 	}
	// }

	if (isset($include_files['js'])) {
		for ($i=0; $i < count($include_files['js']); $i++) {
			$current_index = $include_files['js'][$i];
			for ($x = 0; $x < count($current_index['files']); $x++) {
				$script_src = $materialize_URL . '/' . $current_index['folder'] . '/' . $current_index['files'][$x] . '.js';
			echo '<script src="' . $script_src . '" type="text/javascript"></script>';
			}
		}
	}
?>		
	</body>
</html>