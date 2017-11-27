<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$materialize_URL = base_url( '/third_party/materialize' );
?>
<!--sidenav-->
<div class="net-sidenav">
	<ul id="slide-out" class="side-nav fixed">
		<div class="row valign-wrapper">
			<div class="net-menu">
				<div class="net-navlogo">
					<img class="responsive-img" src="<?php echo $materialize_URL; ?>/images/CE-Patron-Plus.svg">
				</div>
			</div>
		</div>
		<?php $curr_location = $this->uri->slash_rsegment(1); ?>
		<li><a href="<?php echo site_url( $curr_location . 'members' ); ?>"><i class="fa fa-sitemap" aria-hidden="true"></i> Members</a></li>
		<li><a href="<?php echo site_url( $curr_location . 'inventory' ); ?>"><i class="fa fa-briefcase" aria-hidden="true"></i> Inventory</a></li>
		<li><a href="<?php echo site_url( $curr_location . 'settings' ); ?>"><i class="fa fa-wrench" aria-hidden="true"></i> Settings</a></li>
		<li><a href="<?php echo site_url( $curr_location . 'roles' ); ?>"><i class="fa fa-user-times" aria-hidden="true"></i> Roles</a></li>
		<li><a href="<?php echo site_url( $curr_location . 'users' ); ?>"><i class="fa fa-users" aria-hidden="true"></i> Users</a></li>

	</ul>

</div>

<!-- Hide this temporarily -->
<!-- <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a> -->