<!DOCTYPE html>
<?php 
/**
  * dieser code prüft, ob im site-blueprint offline eingeschaltet ist
  * und verweist dann auf die offline-Seite
  */
	if(site()->content()->showpage() == 'nein' ){ go('/offline'); } 
?>
<html lang="de">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<title>VFG Kiel e.V.: <?= $page->title(); ?></title>
<?php 
	print css('/assets/bootstrap-5.2.0/css/bootstrap.css')."\n";
	print css('/assets/bootstrap-icons-1.8.3/bootstrap-icons.css')."\n";
	print css('/assets/css/app.css'); 
	print "\n".js('assets/bootstrap-5.2.0/js/bootstrap.bundle.min.js');
	print "\n".js('assets/js/app.js');
?>
</head>
<body>
	<div id="maincontent" class="col-xs-12 col-md-10 offset-md-1">
		<div class="row">
			<div class="d-flex align-items-center bg-white ps-1 pe-1 py-1" style="border-bottom:2px solid #777; margin-bottom:1.5rem;">
				<a href="/home"><img src="assets/images/logo_vfg_57x50.png"></a>
				<div class="d-flex ms-auto">
					<a href="https://www.fiz-kiel.de"><img src="assets/images/logo_fiz_138x50.png"></a>
				</div>
			</div>
		</div>




