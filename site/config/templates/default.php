<?php
		echo snippet('aa_header');
		echo '<div class="row">';
		echo '<div class="col-12">';
		echo '<h1 class="mt-4" style="margin-bottom:3.0rem">'.$page->title().'</h1>';
		echo '</div>';
		echo '</div>';
		echo '<div class="row" id="main_content">';
		echo '<div class="col-12 fs-5">';
		echo $page->text()->kirbytext();
		echo '</div>';
		echo snippet('aa_footer');
?>