<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (isset($nav_menus)):
	$curr_location = site_url( $this->uri->slash_rsegment(1) . $this->uri->segment(2) );
	$searchBoxValue = $this->uri->segment(3) == 'search' ? $this->uri->segment(4) : '';
	$searchBoxValue = urldecode( $searchBoxValue );
?>
<main>
	<nav class="red darken-1">

		<div class="nav-wrapper">

		<!-- Back -->
		<?php if (in_array('back', $nav_menus)): ?>	
			<a href="" class="brand-logo">Back</a>
		<?php endif; ?>

		<!-- New -->
		<?php if (in_array('new', $nav_menus)): ?>
			<ul id="" class="hide-on-med-and-down">
				<li><a href="<?php echo $curr_location; ?>/new/" class="btn">Add New</a></li>
			</ul>
		<?php endif; ?>

			<ul id="nav-mobile" class="right hide-on-med-and-down">

		<!-- Search -->
		<?php
			if (in_array('search', $nav_menus) || in_array('search_trash', $nav_menus)):
				$searchAction = in_array('search_trash', $nav_menus) ? $curr_location . '/searchtrash/' : $curr_location . '/search/';
		?>
				<li>
					<form action="<?php echo $searchAction; ?>">
						<input type="search" name="s" id="seach" class="input" value="<?php echo $searchBoxValue; ?>" placeholder="Search here...">
					</form>
				</li>
		<?php endif; ?>

		<!-- Logs -->
		<?php if (in_array('logs', $nav_menus)): ?>			
				<li><a href="<?php echo $curr_location; ?>/logs/"><i class="fa fa-history" aria-hidden="true"></i> Logs</a></li>
		<?php endif; ?>

		<!-- Edit History -->
		<?php if (in_array('history', $nav_menus)): ?>			
				<li><a href="<?php echo $curr_location; ?>/edit-history/"><i class="fa fa-history" aria-hidden="true"></i> Edit History</a></li>
		<?php endif; ?>

		<!-- Print -->
		<?php if (in_array('print', $nav_menus)): ?>			
				<li><a href="<?php echo $curr_location; ?>/print/"><i class="fa fa-print" aria-hidden="true"></i> Print</a></li>
		<?php endif; ?>

		<!-- Delete -->
		<?php if (in_array('delete', $nav_menus)): ?>			
				<li><a href="<?php echo $curr_location; ?>/delete/"><i class="fa fa-minus-square" aria-hidden="true"></i> Delete</a></li>
		<?php endif; ?>

		<!-- Recycle Bin -->
		<?php if (in_array('trash', $nav_menus)): ?>			
				<li><a href="<?php echo $curr_location; ?>/trash/"><i class="fa fa-trash" aria-hidden="true"></i> Trash</a></li>
		<?php endif; ?>		

			</ul>

		</div>

	</nav>
</main>
<?php endif; ?>