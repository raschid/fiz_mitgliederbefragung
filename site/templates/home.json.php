<?php 
if($kirby->request()->is('POST')) 
{
	$action = get('action');

	switch($action)
	{
		case 'fizUserAuth':
			snippet('validate_member');
			// -> die Formulardaten befinden sich in "content"! 
			checkAuthData(get('content'));
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

?>

