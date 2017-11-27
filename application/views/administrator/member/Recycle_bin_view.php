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
						<th>Full Name</th>
						<th>Mobile Number</th>
						<th>Landline Info</th>
						<th>Email</th>
						<th>Date Registered</th>
						<th>Actions</th>
					</tr>
				</thead>

				<tbody>
			<?php foreach ($data_list as $value): ?>
			<?php
				$member_ID = $value->member_id;
				$full_name = ucwords($value->member_first_name) . ' ' . strtoupper($value->member_middle_name[0]) . ' ' . ucwords($value->member_last_name);
			?>
					<tr>
						<td><?= $full_name; ?></td>
						<td><?= $value->member_mobile; ?></td>
						<td><?= $value->member_landline; ?></td>
						<td><?= $value->member_email_address; ?></td>
						<td><?= date( "F d, Y g:i:s A", strtotime( $value->member_date_registered ) ); ?></td>
						<td><a href="<?= site_url( $this->uri->slash_rsegment(1) . $this->uri->slash_rsegment(2) . 'viewdeleted/' . $member_ID ); ?>">View</a> | <a href="<?= site_url( $this->uri->slash_rsegment(1) . $this->uri->slash_rsegment(2) . 'restore/' . $member_ID ); ?>" class="teal-text">Restore</a></td>
					</tr>
			<?php endforeach; ?>		
				</tbody>

			</table>

		</div>	

	</div>
<?php endif; ?>
</main>