<?php
/**
 * hier wird zunächst geprüft, ob die nötigen Sessionparameter fiz.x und fiz.y existieren und
 * valide Daten enthalten. Nur dann hat sich das Mitglied erfolgreich authorisiert!
 */
	/*$session = kirby()->session();
	$userdata['mitgliedsnr'] = $session->get('fiz.x');
	$userdata['authcode'] = strrev($session->get('fiz.y'));

	// wenn eine der beiden session-Variablen leer ist: umleiten!
	if( V::empty($userdata['mitgliedsnr']) || V::empty($userdata['authcode']) ){ go('/error'); }
	
    $table = 'mitglieder';
    $cols = '*';
    // authcode und mitgliedsnr müssen Beide richtig sein!
    $where = 'einmalcode = "'.$userdata['authcode'].'" AND mitgliedsnummer = "'.$userdata['mitgliedsnr'].'"';
    $t = Db::first($table,$cols,$where);
	
	// wenn die beiden Angaben nicht zum gleichen Datensatz passen: umleiten!
    if(Db::affected() != 1){ go('/home'); }
   	
   	// wenn der zugehörige Datensatz bereits als "hat_gewaehlt" markiert ist: umleiten!
    if($t->hatgewaehlt() != '0000-00-00 00:00:00' && $t->hatgewaehlt() != NULL){ go('/error'); }*/

/**
 * wenn es bis hier keine Umleitung zu /error gegeben hat, ist die Session gültig und wir können 
 * uns den Ergebnissen widmen:
 * 
 * sind Daten per POST hereingekommen? Wenn nicht, Umleitung ...
 */
if(!$kirby->request()->is('POST')){ go('/error'); }

/**
 * wir holen die Liste der Frage-ids aus dem home-blueprint
 * und speichern sie in $qids
 */
	$qids = array();
	$qids_struct = kirby()->page('home')->questions()->toStructure();
	foreach($qids_struct as $qid)
	{
		$t = $qid->qid()->value(); 
		array_push($qids, $t); 
	}


/**
 * nun sammeln wir die Antwort-Datensätze für jede Frage-ID
 * und basteln das SQL-statement
 */
	$sql_tpl = 'INSERT INTO ergebnisse (`frage_id`, `wert`) VALUES ("##FRAGEID##","##WERT##");';
	$statements = '';

	foreach($qids as $qid)
	{
		// der Eintrag kann nur ja/nein oder enthaltung, also alpha sein.
		// wenn nicht -> überspringen
		if ( !V::alpha(get($qid))){ continue; }
		else {
			$frageid = $qid;
			$wert = get($frageid);
			$statements .= str_replace(['##FRAGEID##','##WERT##'], [$frageid, $wert], $sql_tpl);
		}	
	}
		dump($statements);


// markieren den authcode als "hat_gewaehlt"

// tragen die Ergebnisse ein

// und sagen danke!












	echo snippet('aa_header');
	echo '<div class="row">';
	echo '<div class="col-12">';
	echo '<h1 style="margin-bottom:2.0rem">'.kirby()->page('home')->heading().'</h1>';
	echo '</div>';
	echo '</div>';
	echo '<div class="row" id="main_content">';
	echo '<div class="col-12">';

/** 
 * Wir begrüßen das Mitglied mit vollem Namen.
 * und fügen seine IP-Adresse der session hinzu
 */
/*	$userdata['vorname'] = $t->vorname;
	$userdata['nachname'] = $t->nachname;
	$session->set('fiz.z', $_SERVER['REMOTE_ADDR']);

	$page = $kirby->page('poll');
	
	// workaround, solange die echten Anreden in der DB fehlen ...
	if($t->anrede == Null){
		$anr = array('Liebe', 'Lieber','Liebe', 'Lieber','Liebe', 'Lieber','Liebe', 'Lieber','Liebe', 'Lieber');
		shuffle($anr);
		$anrede = $anr[3];
	}
	else{ $anrede = $t->anrede; }

	echo '<h5 class="mb-4">'.$anrede.' '.$userdata['vorname'].' '.$userdata['nachname'].',</h5>';

	echo $page->welcome()->kirbytext();

	echo snippet('questions/questions');
	echo createPoll();*/


/**
 * wir holen die Liste der Frage-ids aus dem home-blueprint
 */
	$qids = array();
	$qids_struct = kirby()->page('home')->questions()->toStructure();
	foreach($qids_struct as $qid)
	{
		$t = $qid->qid()->value(); 
		array_push($qids, $t); 
	}


	if($kirby->request()->is('POST')) 
	{ 
			dump($qids);

//		foreach($qids as $qid){
//			echo get($qid).'<br>';
//		}
	}

	echo '</div>';
	echo snippet('aa_footer');
?>

