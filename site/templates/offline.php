<?php
snippet('aa_header_offline');

echo '<h1 style="margin-bottom:2.0rem">'.$page->heading().'</h1>';
echo $page->inhalt()->kirbytext();


snippet('aa_footer');
?>