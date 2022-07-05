<?php 
if($kirby->request()->is('POST')) 
{
	$action = get('action');

	switch($action)
	{
		case 'fizUserAuth':
			snippet('validate_member');
			// -> die Formulardaten befinden sich in "content"! 
			if( checkAuthData(get('content')) )
			{
				updateSession(get('content'));
				//go('/poll');
			}
			break;
		default:
			// wenn die action nicht bekannt ist, diesen Fehler zurück geben:
			$return['status'] = 'error';
			$return['titel'] = 'unbekannte Aktion!';
			$return['message'] = 'Die Anfrage konnte nicht bearbeitet werden!';
			returnJSONData($return);
	}
}

function returnJSONData($result)
{
	echo json_encode($result);
	exit;
}

function updateSession($content)
{
	$table = 'mitglieder';
    $cols = 'mitgliedsnummer';
    $where = 'einmalcode = "'.$content['authcode'].'"';
    $t = Db::first($table,$cols,$where);
 	
    // es MUSS ein Ergebnis geben, ist ja gerade geprüft worden ...
    $mitgliedsnummer = $t->mitgliedsnummer();
    $authcode_rev = strrev($content['authcode']);

	$session = kirby()->session();
	$session->set('fiz.x', $mitgliedsnummer);
	$session->set('fiz.y', $authcode_rev);
	return true;
}

?>

