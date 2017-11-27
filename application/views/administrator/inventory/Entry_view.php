<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<main>
	
	<div class="row">
		
	<?php
		$controller_action = isset($entry_action) ? $entry_action : $this->uri->segment(3);
		$segment_action = $controller_action == 'new' ? 'edit/' : 'edit/' . $this->uri->slash_rsegment(4);
		$target_url = site_url( $this->uri->slash_rsegment(1). $this->uri->slash_rsegment(2) . $segment_action );
		echo form_open( '/inventory_controller/save_item/', array('class'=>'col s12'), array('target_url'=>$target_url) );
	?>

		<div class="row">
			<div class="input-field col s12">
				<input id="item_code" name="item_code" type="text" value="<?php echo set_value('item_code'); ?>" class="validate" autofocus="autofocus">
				<label for="item_code">Item Code</label>
			</div>
		</div>

		<div class="row">
			<div class="input-field col s12">
				<input id="item_name" name="item_name" type="text" value="<?php echo set_value('item_name'); ?>" class="validate" autofocus="autofocus">
				<label for="item_name">Item Name</label>
			</div>
		</div>

		<div class="row">
			<div class="input-field col s12">
				<input id="item_price" name="item_price" type="number" value="<?php echo set_value('item_price'); ?>" class="validate">
				<label for="item_price">Price</label>
			</div>
		</div>

		<div class="row">
			<div class="input-field col s12">
				<input id="item_qty" name="item_qty" type="number" value="<?php echo set_value('item_qty'); ?>" class="validate">
				<label for="item_qty">Quantity</label>
			</div>
		</div>

		<div class="row">
			<div class="input-field col s12">
				<textarea name="item_remarks" id="item_remarks" class="materialize-textarea"><?php echo set_value('item_remarks'); ?></textarea>
				<label for="item_remarks">Remarks</label>
			</div>
		</div>

		<!-- Button Starts here. -->
		<div class="row">
			<div class="input-field col s12">
				<input type="submit" name="saveInventory" value="SAVE" id="saveInventory" class="btn-large waves-effect waves-light blue" />
			</div>
		</div>
		<!-- Button Ends here. -->

	<?php echo form_close(); ?>

	</div>

</main>