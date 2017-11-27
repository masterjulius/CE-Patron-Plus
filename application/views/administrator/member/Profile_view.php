<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<main>
<?php	
if ($data_list):
	$profile_id = array(
		'slashed'	=>	$this->uri->slash_rsegment(4),
		'noslash'	=>	$this->uri->segment(4)
	);
	$option_link_prefx =  site_url( $this->uri->slash_rsegment(1) . $this->uri->slash_rsegment(2) );
	$tree_view_link = $option_link_prefx . "tree/" . $profile_id['slashed'];
	$unilevel_bonuses_link = $option_link_prefx . "unilevelbonuses/" . $profile_id['slashed'];
	$delete_link = $option_link_prefx . "delete/" . $profile_id['slashed'];
?>
	<div class="row profile-options">

		<a href="<?php echo $tree_view_link; ?>">View Tree</a>
		<a href="<?php echo $unilevel_bonuses_link; ?>" class="teal-text">View Unilevel Bonuses</a>
		<a href="<?php echo $delete_link; ?>" class="red-text"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>

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
<?php else: ?>	
	
	<div class="row">
		
		<div class="col s12">
			
			<div class="row">
				<div class="col s12 m12">
					<div class="card blue-grey darken-1">
						<div class="card-content white-text">
							<span class="card-title">Oops!</span>
							<p>It seems that this user does not exist anymore.</p>
						</div>
						<div class="card-action">
							<a href="<?php echo site_url( $this->uri->slash_rsegment(1) . $this->uri->slash_rsegment(2) ) ?>"><i class="fa fa-arrow-left" aria-hidden="true"></i> Go back</a>
						</div>
					</div>
				</div>
			</div>

		</div>

	</div>

<?php endif; ?>
</main>