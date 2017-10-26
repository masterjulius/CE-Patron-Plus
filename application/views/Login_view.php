<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid container-login">
	
	<div class="row">
		
		<div class="col s12 login-form-container">
			
		<?php echo form_open( '/users_controller/user_sign_in/', array('class'=>'col s4 offset-s4'), array( 'target_url' => $this->uri->uri_string() ) ); ?>
		<div class="row">
			<div class="input-field col s12">
				<input value="<?php echo set_value('username'); ?>" id="username" name="username" type="text" class="validate" autofocus="autofocus" />
				<label class="active" for="username">Username</label>
			</div>
			<?php echo form_error('username'); ?>

			<div class="input-field col s12">
				<input value="" id="password" name="password" type="password" class="validate" />
				<label class="active" for="password">Password</label>
			</div>
			<?php echo form_error('password'); ?>

			<div class="input-field col s12">
				<input type="submit" name="login" value="LOGIN" class="waves-effect waves-light btn-large blue" />
			</div>

		</div>
		<?php echo form_close(); ?>

		</div>

	</div>

</div>