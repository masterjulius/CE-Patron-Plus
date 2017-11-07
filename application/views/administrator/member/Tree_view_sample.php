<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ( $member_metadata != false && $data_list != false ):
	$full_name = $member_metadata->member_first_name . " " . $member_metadata->member_middle_name . " " . $member_metadata->member_last_name;
?>
<main>
	
	<div class="row name-container">
		
		<div class="col s12">
			<h4 class="center"><?php echo $full_name; ?></h4>
		</div>

	</div>

	<div class="row tree-container">
		
		<div class="col s12">
			<ul class="collapsible popout child-tree-list" data-collapsible="expandable">
		<?php
			foreach ($data_list as $list):
				$member_id = $list->member_id;
				$child_name = $list->member_first_name . " " . $list->member_middle_name . " " . $list->member_last_name;
		?>
				<li>
					<div class="collapsible-header child-list" data-id="<?php echo $member_id; ?>"><i class="material-icons"></i> <?php echo $child_name; ?></div>
					<div class="collapsible-body sub-child-body"></div>
				</li>
		<?php
			endforeach;
		?>
			</ul>
		</div>	

	</div>

</main>
<?php endif; ?>