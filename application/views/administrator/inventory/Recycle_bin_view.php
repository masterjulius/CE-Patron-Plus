<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<main>
<?php if ($data_list): ?>	
	<div class="row">

		<div class="col s12">
			
			<table class="striped">
			
				<thead>
					<tr class="centered">
						<th>Item Code</th>
						<th>Item Name</th>
						<th>Item Remarks</th>
						<th>Date Added</th>
						<th>Actions</th>
					</tr>
				</thead>

				<tbody>
			<?php
				foreach ($data_list as $key => $value):
					$item_id = $value->item_id;
					$item_remarks = $value->item_remarks;
					$substr_remarks = mb_substr($item_remarks, 0, 50, mb_detect_encoding($item_remarks));
			?>
					<tr>
						<td><?php echo $value->item_code; ?></td>
						<td><?php echo $value->item_name; ?></td>
						<td><?php echo $substr_remarks; ?></td>
						<td><?php echo date( "F d, Y h:i:s A", strtotime($value->item_created_date) ); ?></td>
						<td><a href="<?= site_url( $this->uri->slash_rsegment(1) . $this->uri->slash_rsegment(2) . 'viewtrash/' . $item_id ); ?>">View</a> | <a href="<?= site_url( $this->uri->slash_rsegment(1) . $this->uri->slash_rsegment(2) . 'restore/' . $item_id ); ?>" class="teal-text">Restore</a></td>
					</tr>
			<?php		
				endforeach;
			?>	
				</tbody>
				
			</table>

		</div>

	</div>
<?php endif; ?>
</main>