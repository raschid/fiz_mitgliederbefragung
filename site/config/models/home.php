<?php
class HomePage extends Page 
{
	public function checkAuthData($data)
    {
        // sind die Formulardaten formal in Ordnung?
        // areFormDataValid() holt sich die Daten per get()
        if($this->areFormDataValid($data) == false)
        {
            $return['status'] = 'error';
            $return['message'] = 'Die angegebenen Daten sind nicht valide!';
            returnJSONData($return);
            exit;
        }
        else
        {
            // hier das Form-Objekt erstellen
            $form = [ // nimmt die Formulareigenschaften auf
                $authcode => trim(get('authcode')),
                $nachname => trim(get('nachname')),
                $geburtstag => trim(get('geburtstag'))
            ];

            if( $this.isAuthcodeInDatabase($form->authcode) )
            {
                if( $this.hasAuthcodeAlreadyVoted($form->authcode) )
                {
                    $return['status'] = 'error';
                    $return['message'] = 'Der angegebene Code ist bereits verwendet worden!';
                    returnJSONData($return);
                    exit;
                }
                else
                {
                    if( $this.doMemberDataMatch($form) )
                    {
                        $pollForm = page('home')->getPoll();
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
	private function areFormDataValid()
	{
	    $valid = true; // wird auf false gesetzt, sobald ein Fehler auftaucht! 

		/** ********************************************************************
		 * authcode
		********************************************************************* */
		$temp = trim(get('authcode'));
	    if( !V::empty($temp) && V::alphanum( $temp ) == false )
	    { $valid = false; }

		/** ********************************************************************
		 * Nachname
		********************************************************************* */    

		$temp = trim(get('nachname'));
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

		$temp = trim(get('geburtstag'));
		//erwartetes Muster: dd.mm.jjjj
		$pattern = '/(0?[1-9]|[12][0-9]|3[01])[\/\-.](0?[1-9]|1[012])[\/\-.]\d{4}/i';

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
	 * @param   array    $form   assoziatives array mit den Formulardaten
	 * @return  bool  
	 */
	  private function isAuthcodeInDatabase($authcode)
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
 * @param   array    $form   assoziatives array mit den Formulardaten
 * @return  bool
 */
	private function hasAuthcodeAlreadyVoted($authcode)
	{
		$table = 'mitglieder';
		$cols = ['hatgewaehlt'];
		$where = 'einmalcode = "'.$authcode.'"';
		$t = Db::first($table,$cols,$where);
		if($t->hatgewaehlt() != '0000-00-00 00:00:00')
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
	private function doMemberDataMatch($form)
	{ 
		$table = 'mitglieder';
		$cols = ['mitgliedsnummer','nachname','geburtstag'];
		$where = 'einmalcode = "'.$form['code'].'"';
		$t = Db::first($table,$cols,$where);

		$match = true;

		if($t->nachname != $form->nachname){ $match = false; }

		// array!
		$bd = explode('.',get('geburtstag'));
		$birthdate_form = $bd[2].'-'.$bd[1].'-'.$bd[0];

		if($birtday_form != $t->geburtstag()){ $match = false; }
		return $match; 
	}

}
?>