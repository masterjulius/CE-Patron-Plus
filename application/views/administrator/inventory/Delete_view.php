<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$action = $this->uri->segment(3);
$item_id = $this->uri->segment(4);
switch ($action) {
	case 'delete':
		$msg_action = 'remove';
		break;
	case 'restore':
		$msg_action = 'restore';
		break;
	default:
		$msg_action = 'remove';
		break;
}
?>
<main>
	<div class="row">

		<div class="col s12">
			
			<div class="row">
				<div class="col s12 m6">
					<div class="card blue-grey darken-1">
						<div class="card-content white-text">
							<span class="card-title">Pause for a moment!</span>
							<p>Are you sure you want to <?php echo $msg_action; ?> this item?</p>
						</div>
						<div class="card-action">
						<?php echo form_open('', '', array('item_id'=>$item_id)); ?>
							<input type="submit" name="<?php echo $action; ?>_yes" value="Yes" class="btn btn-large blue" />
							<input type="submit" name="<?php echo $action; ?>_no" value="No" class="btn btn-large blue" />
						<?php echo form_close(); ?>
						</div>
					</div>
				</div>
			</div>

		</div>
	
	</div>
</main>