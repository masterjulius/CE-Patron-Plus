<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ( $member_metadata != false && $data_list != false ):
	$full_name = $member_metadata->member_first_name . " " . $member_metadata->member_middle_name . " " . $member_metadata->member_last_name;
	$colors = array('red', 'teal', 'pink', 'purple', 'red darken-4', 'pink darken-4', 'purple darken-4', 'pink accent-3', 'green', 'orange', 'deep-orange', 'brown', 'grey', 'blue-grey darken-4');
	$color_count = count( $colors ) - 1;
?>
<main>
	
	<div class="row name-container">
		
		<div class="col s12">
			<h4 class="center"><?php echo $full_name; ?></h4>
		</div>

	</div>

	<div class="row tree-container white-text">
		
		<div class="col s12">
			<ul class="collapsible popout child-tree-list" data-collapsible="expandable" data-depth="1">
		<?php
			$indexLvlOne = rand( 0, $color_count );
			foreach ($data_list as $list):
				$lvlOneprefx = $list['parent'];
				$lvlOneMemberID = $lvlOneprefx['member_id'];
				$lvlOneFullName = $lvlOneprefx['member_first_name'] . " " . $lvlOneprefx['member_middle_name'] . " " . $lvlOneprefx['member_last_name'];
		?>
				<li>
					<div class="collapsible-header child-list <?php echo $colors[$indexLvlOne]; ?>" data-id="<?php echo $lvlOneMemberID; ?>"><i class="material-icons"></i> <?php echo $lvlOneFullName; ?></div>
					<div class="collapsible-body sub-child-body <?php echo $colors[$indexLvlOne]; ?>">
						<ul class="collapsible popout child-tree-list" data-collapsible="expandable" data-depth="2">
		<?php
					$indexLvlTwo = rand( 0, $color_count );;
					foreach ( (array) $list['childrens'] as $lvlTwoList):
						$lvlTwoPrefx = $lvlTwoList['parent'];
						$lvlTwoMemberID = $lvlTwoPrefx['member_id'];
						$lvlTwoFullName = $lvlTwoPrefx['member_first_name'] . " " . $lvlTwoPrefx['member_middle_name'] . " " . $lvlTwoPrefx['member_last_name'];
		?>
							<li>
								<div class="collapsible-header child-list <?php echo $colors[$indexLvlTwo]; ?>" data-id="<?php echo $lvlTwoMemberID; ?>"><i class="material-icons"></i> <?php echo $lvlTwoFullName; ?></div>
								<div class="collapsible-body sub-child-body <?php echo $colors[$indexLvlTwo]; ?>">
									<ul class="collapsible popout child-tree-list" data-collapsible="accordion" data-depth="3">
		<?php
									$indexLvlThree = rand( 0, $color_count );;
									foreach ( (array) $lvlTwoList['childrens'] as $lvlThreeList):
										$lvlThreePrefx = $lvlThreeList['parent'];
										$lvlThreeMemberID = $lvlThreePrefx['member_id'];
										$lvlThreeFullName = $lvlThreePrefx['member_first_name'] . " " . $lvlThreePrefx['member_middle_name'] . " " . $lvlThreePrefx['member_last_name'];
		?>
										<li>
											<div class="collapsible-header child-list <?php echo $colors[$indexLvlThree]; ?>" data-id="<?php echo $lvlThreeMemberID; ?>"><i class="material-icons"></i> <?php echo $lvlThreeFullName; ?></div>
											<!-- <div class="collapsible-body sub-child-body"></div> -->
										</li>
		<?php
										$indexLvlThree++;
										if ( $indexLvlThree >= $color_count ) {
											$indexLvlThree = 0;
										}
									endforeach;
		?>
									</ul>
								</div>
							</li>	
		<?php
						$indexLvlTwo++;
						if ( $indexLvlTwo >= $color_count ) {
							$indexLvlTwo = 0;
						}
					endforeach;		
		?>
						</ul>	
					</div>
				</li>
		<?php
				$indexLvlOne++;
				if ( $indexLvlOne >= $color_count ) {
					$indexLvlOne = 0;
				}
			endforeach;
		?>
			</ul>
		</div>	

	</div>

</main>
<?php endif; ?>