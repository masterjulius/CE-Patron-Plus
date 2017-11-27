<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ($meta_datas != false):
	$item_id = $meta_datas->item_id;
	$curr_action = site_url( $this->uri->slash_rsegment(1) . $this->uri->slash_rsegment(2) );
?>
<main>
	
	<div class="row">
		
		<div class="col s12">

			<div class="row">
				<div class="col s12 m12">
					<div class="card blue-grey darken-1">

						<div class="card-action">
							<div class="row right">
								<a href="<?php echo $curr_action . 'edit/' . $item_id; ?>" class=""><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
								<a href="<?php echo $curr_action . 'delete/' . $item_id; ?>" class="red-text"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>
							</div>
						</div>

						<div class="card-content white-text">

							<div class="row">
								<div class="col s12">
									<span class="card-title">Item Details</span>
								</div>
							</div>
							
							<div class="row">
								
								<div class="row">
									<div class="input-field col s3">Item Code:</div>
									<div class="input-field col s9"><?php echo $meta_datas->item_code; ?></div>
								</div>
								<div class="row">
									<div class="input-field col s3">Item Name:</div>
									<div class="input-field col s9"><?php echo $meta_datas->item_name; ?></div>
								</div>
								<div class="row">
									<div class="input-field col s3">Item Price:</div>
									<div class="input-field col s9"><?php echo $meta_datas->item_price; ?></div>
								</div>
								<div class="row">
									<div class="input-field col s3">Item Quantity:</div>
									<div class="input-field col s9"><?php echo $meta_datas->item_qty; ?></div>
								</div>
								<div class="row">
									<div class="input-field col s3">Item Remarks:</div>
									<div class="input-field col s9"><?php echo $meta_datas->item_remarks; ?></div>
								</div>
								<div class="row">
									<div class="input-field col s3">Date Created:</div>
									<div class="input-field col s9"><?php echo date( "F d, Y h:i:s A", strtotime($meta_datas->item_created_date) ) ?></div>
								</div>

							</div>

						</div>

					</div>
				</div>
			</div>

		</div>

	</div>

</main>
<?php endif; ?>