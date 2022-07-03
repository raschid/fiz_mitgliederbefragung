<?php 
if($kirby->request()->is('POST')) 
{
	$action = get('action');

	switch($app)
	{
		case 'fizUserAuth':
			snippet('pages/verwaltung/verwaltung.json.benutzer');
			benutzer();
			break;
		default:
			// wenn die application nicht bekannt ist, diesen Fehler zurück geben:
			$return['status'] = 'error';
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

