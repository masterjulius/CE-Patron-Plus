<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<main>

	<div class="row">
<?php
	if ( $data_list):

	$member_id = $this->uri->segment(4);
	$controller_action = isset($entry_action) ? $entry_action : $this->uri->segment(3);
	$segment_action = $controller_action == 'new' ? 'edit/' : 'edit/' . $this->uri->slash_rsegment(4);
	$target_url = site_url( $this->uri->slash_rsegment(1). $this->uri->slash_rsegment(2) . $segment_action );
	echo form_open( '/members_controller/save_member/' . $member_id . '/', array('class'=>'col s12'), array('target_url'=>$target_url,'recruiter_id'=>$data_list->h_parent_id) );

		$parent_name = $parent_metadata->member_first_name . ' ' . $parent_metadata->member_middle_name[0] . ' ' . $parent_metadata->member_last_name;
?>

		<!-- Recruiter Informations starts here. -->
		<div class="row">
			<div class="input-field col s12">
				<input id="recruiter" name="recruiter" type="text" value="<?php echo $parent_name; ?>" class="autocomplete" autofocus="autofocus">
				<label for="recruiter">Recruiter</label>
			</div>
		</div>
		<!-- Recruiter Informations ends here. -->
		
		<!-- Name Informations starts here. -->
		<div class="row">
			<div class="input-field col s4">
				<input id="first_name" name="first_name" type="text" value="<?php echo $data_list->member_first_name; ?>" class="validate">
				<label for="first_name">First Name</label>

				<?php echo form_error('first_name'); ?>
			</div>
			
			<div class="input-field col s4">
				<input id="middle_name" name="middle_name" type="text" value="<?php echo $data_list->member_middle_name; ?>" class="validate">
				<label for="middle_name">Middle Name</label>

				<?php echo form_error('middle_name'); ?>
			</div>
			
			<div class="input-field col s4">
				<input id="last_name" name="last_name" type="text" value="<?php echo $data_list->member_last_name; ?>" class="validate">
				<label for="last_name">Last Name</label>

				<?php echo form_error('last_name'); ?>
			</div>
			
		</div>
		<!-- Name Informations ends here. -->

		<!-- Contact Informations start here -->
		<div class="row">
			
			<div class="input-field col s6">
				<input id="mobile" name="mobile" type="text" value="<?php echo $data_list->member_mobile; ?>" class="validate">
				<label for="mobile">Mobile Number</label>

				<?php echo form_error('mobile'); ?>
			</div>

			<div class="input-field col s6">
				<input id="landline" name="landline" type="text" value="<?php echo $data_list->member_landline; ?>" class="validate">
				<label for="landline">Landline Number</label>

				<?php echo form_error('landline'); ?>
			</div>

		</div>
		<!-- Contact Informations ends here -->

		<!-- Mailing Informations starts here -->
		<div class="row">
			<div class="col s12">
				<label>Mailing Informations</label>
			</div>
			<div class="input-field col s6">
				<textarea name="mailing_address" id="mailing_address" class="materialize-textarea"><?php echo $data_list->member_mailing_address; ?></textarea>
				<label for="mailing_address">Mailing Address</label>
				<?php echo form_error('mailing_address'); ?>
			</div>
			<div class="input-field col s6">
				<input id="email_address" name="email_address" type="email" value="<?php echo $data_list->member_email_address; ?>" class="validate">
				<label for="email_address">Email Address</label>
				<?php echo form_error('email_address'); ?>
			</div>

		</div>
		<!-- Mailing Informations ends here -->

		<!-- Gender, Birthday and Civil Status Informations start here -->
		<div class="row">
			
			<div class="col s2">
				<label>Gender</label>
				<p>
					<input name="gender" type="radio" value="1" class="with-gap" id="male" <?php if ( $data_list->member_gender == '1' ) { echo 'checked'; } ?> />
					<label for="male">Male</label>
				</p>
				<p>
					<input name="gender" type="radio" value="0" class="with-gap" id="female" <?php if ( $data_list->member_gender == '0' ) { echo 'checked'; } ?> />
					<label for="female">Female</label>
				</p>
				<p><?php echo form_error('gender'); ?></p>
			</div>

			<div class="col s5">
				<label id="birthdate">Birth Date</label>
				<input type="text" name="birthdate" value="<?php echo $data_list->member_birthdate; ?>" id="birthdate" class="datepicker">
				<?php echo form_error('birthdate'); ?>
			</div>

			<div class="col s5">

				<label>Marital Status</label>

				<p>
					<input name="civil_status" type="radio" value="1" class="with-gap" id="single" <?php if ( $data_list->member_civil_status == '1' ) { echo 'checked'; } ?> />
					<label for="single">Single</label>
				</p>
				<p>
					<input name="civil_status" type="radio" value="2" class="with-gap" id="married" <?php if ( $data_list->member_civil_status == '2' ) { echo 'checked'; } ?> />
					<label for="married">Married</label>
				</p>
				
				<p>
					<input name="civil_status" type="radio" value="3" class="with-gap" id="widowed" <?php if ( $data_list->member_civil_status == '3' ) { echo 'checked'; } ?> />
					<label for="widowed">Widowed</label>
				</p>
				<p>
					<input name="civil_status" type="radio" value="4" class="with-gap" id="separated" <?php if ( $data_list->member_civil_status == '4' ) { echo 'checked'; } ?> />
					<label for="separated">Separated</label>
				</p>

				<p><?php echo form_error('civil_status'); ?></p>
				
			</div>

		</div>
		<!-- Gender, Birthday and Civil Status Informations ends here -->

		<!-- User Informations start here -->
		
		<!-- <div class="row">

			<div class="col s12">
				<label>User Accounts</label>
			</div>
			
			<div class="input-field col s4">
				<input id="username" name="username" type="text" value="<?php //echo $data_list->user_name; ?>" class="validate">
				<label for="username">User Name</label>
				<?php //echo form_error('username'); ?>
			</div>

			<div class="input-field col s4">
				<input id="password" name="password" type="password" class="validate">
				<label for="password">Password</label>
			</div>

			<div class="input-field col s4">
				<input id="c_password" name="c_password" type="password" class="validate">
				<label for="c_password">Confirm Password</label>
			</div>

		</div> -->

		<!-- User Informations ends here -->

		<!-- Business Informations Starts here -->

		<div class="row">
			
			<div class="input-field col s12">
				<textarea name="business" id="business" class="materialize-textarea"><?php echo $data_list->business_name; ?></textarea>
				<label for="business">Business Name</label>
				<?php echo form_error('business'); ?>
			</div>

		</div>

		<!-- Business Informations Ends here -->

		<!-- Button Starts here. -->
		<div class="row">
			<div class="input-field col s12">
				<input type="submit" name="updateMember" value="UPDATE" id="updateMember" class="btn-large waves-effect waves-light blue" />
			</div>
		</div>
		<!-- Button Ends here. -->

<?php		
	echo form_close();

	endif;
?>
	</div>

</main>