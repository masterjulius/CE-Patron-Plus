<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$option_link_prefx =  site_url( $this->uri->slash_rsegment(1). $this->uri->slash_rsegment(2) );
$tree_view_link = $option_link_prefx . "treeview/" . $this->uri->slash_rsegment(4);
?>
<main>

	<div class="row profile-options">
		
		<a href="<?php echo $tree_view_link; ?>">View Tree</a>

	</div>

	<div class="row profile-container">
		
		<div class="col s12">
			<div class="col s3">
				<p>Full Name:</p>
			</div>
			<div class="col s9">
				<p>
					<em><?php echo $data_list->member_first_name . " " . $data_list->member_middle_name . " " . $data_list->member_last_name; ?></em>
				</p>
			</div>
		</div>
		<div class="col s12">
			<div class="col s3">
				<p>:</p>
			</div>
			<div class="col s9">
				<p><em></em></p>
			</div>
		</div>
		<div class="col s12">
			<div class="col s3">
				<p>:</p>
			</div>
			<div class="col s9">
				<p><em></em></p>
			</div>
		</div>
		<div class="col s12">
			<div class="col s3">
				<p>:</p>
			</div>
			<div class="col s9">
				<p><em></em></p>
			</div>
		</div>
		<div class="col s12">
			<div class="col s3">
				<p>:</p>
			</div>
			<div class="col s9">
				<p><em></em></p>
			</div>
		</div>
		<div class="col s12">
			<div class="col s3">
				<p>:</p>
			</div>
			<div class="col s9">
				<p><em></em></p>
			</div>
		</div>

	</div>

</main>