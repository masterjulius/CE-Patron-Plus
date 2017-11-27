<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<main>
	
	<div class="row">
		
		<div class="" id="chart-container"></div>

	</div>

</main>

<?php
	$materialize_URL = base_url( '/third_party/materialize' );
	$images_path = $materialize_URL . '/images/';
	// extra meta datas here
	$top_member_id = $member_metadata->member_id;
	$dataInfos = array(
		array(
			"id"		=>	$top_member_id,
			"parentId"	=>	null,
			"Name"		=>	($member_metadata->member_first_name) . " " . ($member_metadata->member_middle_name[0]) . " " . ($member_metadata->member_last_name),
			"img"		=>	($member_metadata->member_gender == 1 ? $images_path . 'boy.svg' : $images_path . 'girl.svg')
		)
	);
	if ($data_list):
		foreach ($data_list as $key => $value) {
			$level_one_parent = $value['parent'];
			$appendDatas = array(
				"id"		=>	$level_one_parent['member_id'],
				"parentId"	=>	$top_member_id,
				"Name"		=>	($level_one_parent['member_first_name']) . " " . ($level_one_parent['member_middle_name'][0]) . " " . ($level_one_parent['member_last_name']),
				"img"		=>	($level_one_parent['member_gender'] == 1 ? $images_path . 'boy.svg' : $images_path . 'girl.svg')
			);
			array_push($dataInfos, $appendDatas);

			// Mid Level
			if ( !empty( $mid_value = $value['childrens'] ) ) {

				foreach ($mid_value as $midKey => $midValue) {
					$level_two_parent = $midValue['parent'];
					array_push($dataInfos,
						array(
							"id"		=>	$level_two_parent['member_id'],
							"parentId"	=>	$level_one_parent['member_id'],
							"Name"		=>	($level_two_parent['member_first_name']) . " " . ($level_two_parent['member_middle_name'][0]) . " " . ($level_two_parent['member_last_name']),
							"img"		=>	($level_two_parent['member_gender'] == 1 ? $images_path . 'boy.svg' : $images_path . 'girl.svg')
						)
					);

					// Third Level
					if ( !empty( $bottom_value = $midValue['childrens'] ) ) {

						foreach ($bottom_value as $bottomKey => $bottomValue) {
							$level_three_parent = $bottomValue['parent'];
							array_push($dataInfos,
								array(
									"id"		=>	$level_three_parent['member_id'],
									"parentId"	=>	$level_two_parent['member_id'],
									"Name"		=>	($level_three_parent['member_first_name']) . " " . ($level_three_parent['member_middle_name'][0]) . " " . ($level_three_parent['member_last_name']),
									"img"		=>	($level_three_parent['member_gender'] == 1 ? $images_path . 'boy.svg' : $images_path . 'girl.svg')
								)
							);

						}

					}

				}

			}

		}
	endif;	
	// annabel
	// sara
	// belinda
	// cassandra
	// deborah
	// lena
	// monica
	// ula
	// eve
	// tal
	// vivian
	// ada
	// helen
	$extracted_datas = array(
		"theme"				=>	"deborah",
		"color"				=>	"orange",
		"enableGridView"	=>	true,
		"enableDetailsView"	=>	false,
		"enablePrint"		=>	true,
		"expandToLevel"		=>	4,
		"photoFields"		=>	array("img"),
		"enableEdit"		=>	false,
		"dataSource"		=>	$dataInfos
	);

?>
<script type="text/javascript">var chartDatas = <?php echo json_encode($extracted_datas); ?>;</script>