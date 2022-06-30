<?php 
	if($kirby->request()->is('POST')):

	/**
	 *
	 * Block comment
	 *
	 */
	
	

	else:


		echo '<div class="row">';
		echo snippet('aa_header');
		echo '<h1 style="margin-bottom:2.0rem">'.$page->heading().'</h1>';
		echo $page->einleitung()->kirbytext();

		//echo '</div>';

		//$count = Db::count('mitglieder', 'hatgewaehlt = "0000-00-00 00:00:00"');
		//echo 'DB-Count: '.$count;


		echo snippet('authenticate_member');


		//echo snippet('questions/questions');
		echo snippet('aa_footer');
	endif;
?>

