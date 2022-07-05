<?php
		echo snippet('aa_header');
		echo '<div class="row">';
		echo '<div class="col-12">';
		echo '<h1 style="margin-bottom:2.0rem">'.kirby()->page('home')->heading().'</h1>';
		echo '</div>';
		echo '</div>';
		echo '<div class="row" id="main_content">';
		echo '<div class="col-12">';
		echo snippet('questions/questions');
		echo '</div>';
		echo snippet('aa_footer');
?>

