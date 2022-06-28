<?php
  $authcode = '';
  $readonly = '';

/**
 * 01:
 * Hier wird geprüft, ob über den URL oder das Formular ein Authcode mitgeliefert
 * wurde und ob er formal korrekt ist.
 * 
 * Der authcode besteht aus 12 alphanumerischen Zeichen.
 * Es wird zwischen Groß- und Kleinschreibung unterschieden
 *
 * Der authcode wird hier als Variable übergeben (statt ihn über get('authcode') zu holen),
 * damit ich auch über POST keine Probleme bekomme ...
 */
  function isAuthcodeAvailable($code)
  {
    if(!V::empty($code) && V::alphanum($code)){ return true; }
    return false;  
  }

/**
 * 02: prüft, ob der authcode in der Datenbank vorhanden ist, 
 *  
 */
  function isAuthcodeInDatabase($code)
  { 

  }

/**
 * 03: prüft, ob der authcode bereits als "hat_gewählt" markiert wurde
 *
 */
  function hasAuthcodeAlreadyVoted($code){ }

/**
 * 04: prüft, ob Nachname und Geburtsdatum in der Datenbank zu den eingegebenen Daten passen
 *
 * wenn ja, wird ein Zufallsstring aus timestamp und 8-stelligem alphanumerischem String erzeugt.
 * Dieser wird der Umfrage "hidden" mitgegeben.
 * 
 * authcode und Mitgliedsnummer werden in einer (JSON-) Datei gespeichert, die den Namen des Zufallsstringes trägt.
 */
  function doMemberDataMatch($code){ }    

/**
 * prüft, ob die Formulardaten valide sind.
 */
  function formDataAreValid(){}





/**
 * wenn der authcode im URL mitgeliefert wird, handelt es sich um den Aufruf über den Einladungslink
 * dann reicht es, das Formular nur mit validiertem authcode auszugeben
 */
if($kirby->request()->is('GET'))
{
  if( isAuthcodeAvailable(get('authcode')) )
  {
    $authcode = get('authcode');
    $readonly = ' readonly';
  }
}



/**
 * wenn der request über OOST hereinkommt, ist es das ausgefüllte Formular
 * - dann prüfen, ob die Daten in Ordnung sind
 * - im Erfolgsfall den Fragebogen zurück geben
 * - sonst eine Fehlermeldung
 */
elseif($kirby->request()->is('POST'))
{

}

?>

<div class="row">
  <div class="col-xs-12 offset-xs-1 col-md-4 offset-md-1">
    <div class="mb-3">
      <label for="fiz_auth" class="form-label">Authentifizierungscode</label>
      <input type="text" class="form-control" id="fiz_auth" value="<?= $authcode; ?>"<?= $readonly; ?>>
    </div>
    <div class="mb-3">
      <label for="fiz_name" class="form-label">Nachname</label>
      <input type="text" class="form-control" id="fiz_name" placeholder="bitte hier Deinen Nachnamen eingeben">
    </div>
    <div class="mb-3">
      <label for="fiz_birthdate" class="form-label">Geburtsdatum</label>
      <input type="date" class="form-control" id="fiz_birthdate" placeholder="bitte hier Dein Geburtsdatum eingeben">
    </div>
  </div>
</div>
