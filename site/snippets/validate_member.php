<?php
/**
 * /site/snippets/validate_member.php
 *
 *
 */


function checkAuthData($data)
{

    // sind die Formulardaten formal in Ordnung?
    // areFormDataValid() holt sich die Daten per get()
    if(areFormDataValid($data) == false)
    {
        $return['status'] = 'error';
        $return['message'] = 'Die angegebenen Daten sind nicht valide!';
        returnJSONData($return);
        exit;
    }
    else
    {
        if( isAuthcodeInDatabase($data['authcode']) )
        {
            if( hasAuthcodeAlreadyVoted($data['authcode']) )
            {
                $return['status'] = 'error';
                $return['message'] = 'Der angegebene Code ist bereits verwendet worden!';
                returnJSONData($return);
                exit;
            }
            else
            {
                if( doMemberDataMatch($data) )
                {
                    // wenn wir hier gelandet sind, ist das Mitglied authorisiert
                    // an der Umfrage teilzunehmen
                    snippet('questions/questions');
                    $pollForm = createPoll();
                    $return['status'] = 'success';
                    $return['pollform'] = $pollForm;
                    returnJSONData($return);
                    exit;
                }
                else
                {
                    $return['status'] = 'error';
                    $return['message'] = 'Die Mitgliedsdaten sind nicht korrekt!';
                    returnJSONData($return);
                    exit;
                }
            }
        }
        else
        {
            $return['status'] = 'error';
            $return['message'] = 'Der angegebene Code ist nicht gültig!';
            returnJSONData($return);
            exit;
        }
    }
}

/**
 * prüft zunächst, ob die Formulardaten formal valide sind.
 * erst dann werden sie mit den Daten aus der DB verglichen 
 * 
 * @param   form    Input vom HTML-Formular
 * @return  bool
 */
function areFormDataValid($data)
{

    $valid = true; // wird auf false gesetzt, sobald ein Fehler auftaucht! 

	/** ********************************************************************
	 * authcode
	********************************************************************* */
	$temp = trim($data['authcode']);
    if( !V::empty($temp) && V::alphanum( $temp ) == false )
    { $valid = false; }

	/** ********************************************************************
	 * Nachname
	********************************************************************* */

	$temp = trim($data['nachname']);
    // wir entfernen zunächst alle ERLAUBTEN nicht-Wort-Zeichen aus dem String
    // und testen dann, ob noch weitere nicht-Wort-Zeichen im Namen enthalten sind:
    $pattern_erlaubt = "[ |'|-|_|ä|ü|ö|ß|Ä|Ü|Ö]";
    $replacement = '';
    $temp = preg_replace( $pattern_erlaubt, $replacement, $temp);    
    $pattern_nicht_erlaubt = '/\W/';

    if( preg_match( $pattern_nicht_erlaubt, $temp ) > 0 )
    { $valid = false; }

	/** ********************************************************************
	 * Geburtstag
	********************************************************************* */

	$temp = trim($data['geburtstag']);
	//erwartetes Muster: dd.mm.jjjj
	$pattern = '/(0?[1-9]|[12][0-9]|3[01])[\/\-.](0?[1-9]|1[012])[\/\-.]\d{4}/';

    if( preg_match( $pattern, $temp ) < 1 )
    { $valid = false; }

    return $valid;
}

/** ********************************************************************
* 02 prüfen, ob Formulardaten in DB enthalten sind
********************************************************************* */

/**
 * prüft, ob der authcode in der Datenbank vorhanden ist, 
 *
 * @param   string    $authcode  
 * @return  bool  
 */
  function isAuthcodeInDatabase($authcode)
  { 
    $table = 'mitglieder';
    $cols = '*';
    $where = 'einmalcode = "'.$authcode.'"';
    $t = Db::first($table,$cols,$where);
    if(Db::affected() == 1)
    { return true; }
    return false;
  }

/**
* prüft, ob der authcode bereits als "hat_gewählt" markiert wurde
* Voraussetzung ist, dass isAuthcodeInDatabase() true zurück liefert!
* 
* @param   array    $authcode   assoziatives array mit den Formulardaten
* @return  bool
*/
function hasAuthcodeAlreadyVoted($authcode)
{
	$table = 'mitglieder';
	$cols = ['hatgewaehlt'];
	$where = 'einmalcode = "'.$authcode.'"';
	$t = Db::first($table,$cols,$where);
	if($t->hatgewaehlt() != '0000-00-00 00:00:00' && $t->hatgewaehlt() != NULL)
	{ return true; }
	return false;
}

/**
* prüft, ob Nachname und Geburtsdatum in der Datenbank zu den eingegebenen Daten passen
* wenn ja, wird ein Zufallsstring aus timestamp und 8-stelligem alphanumerischem String erzeugt.
* Dieser wird der Umfrage "hidden" mitgegeben.
* authcode und Mitgliedsnummer werden in einer (JSON-) Datei gespeichert, die den Namen des Zufallsstringes trägt.
* 
* !! das Geburtsdatum steht in der DB in einem Date-field mit dem Format yyyy-mm-dd !!
* 
* @param   string    $code   der Einmalcode aus dem Newsletter
* @return  bool
*/
function doMemberDataMatch($data)
{ 
	$table = 'mitglieder';
	$cols = ['mitgliedsnummer','nachname','geburtstag'];
	$where = 'einmalcode = "'.$data['authcode'].'"';
	$t = Db::first($table,$cols,$where);

	$match = true;

	if($t->nachname != $data['nachname']){ $match = false; }

	// array!
	$bd = explode('.',$data['geburtstag']);
	$birthdate_form = $bd[2].'-'.$bd[1].'-'.$bd[0];

	if($birthdate_form != $t->geburtstag()){ $match = false; }
	return $match; 
}
?>