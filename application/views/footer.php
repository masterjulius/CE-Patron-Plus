<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$materialize_URL = base_url( '/third_party/materialize' );
$materializeJS = $materialize_URL . '/js/materialize-custom.js';
// if ( isset($materialize_custom_JS) ) {
// 	if ($materialize_custom_JS == true) {
// 		$materializeJS = $materialize_URL . '/js/materialize-custom.js';
// 	}
// }
?>
		<script src="<?php echo $materialize_URL; ?>/js/jquery-3.2.1.min.js" type="text/javascript"></script>
		<script src="<?php echo $materializeJS; ?>" type="text/javascript"></script>
		<script src="<?php echo $materialize_URL; ?>/js/main.js" type="text/javascript"></script>
	</body>
</html>