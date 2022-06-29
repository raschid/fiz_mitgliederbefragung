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
 * wenn der request über POST hereinkommt, ist es das ausgefüllte Formular
 * - dann prüfen, ob die Daten in Ordnung sind
 * - im Erfolgsfall den Fragebogen zurück geben
 * - sonst eine Fehlermeldung
 */
elseif($kirby->request()->is('POST'))
{

}

?>



<div class="row">
  <div class="ms-4 mt-3 mb-3 col-xs-8 col-sm-8 col-md-6 col-lg-5 alert alert-dark" style="border:1px solid #ccc;border-radius:15px;Als">
    <h5 class="mt-3 mb-3">Als Mitglied authentifizieren:</h5>
    <div class="mb-3">
      <label for="fiz_auth" class="form-label fw-bold">Authentifizierungscode</label>
      <input type="text" class="form-control" id="fiz_auth" placeholder="Code aus der Einladungsmail" value="<?= $authcode; ?>"<?= $readonly; ?>>
    </div>
    <div class="mb-3">
      <label for="fiz_name" class="form-label fw-bold">Nachname</label>
      <input type="text" class="form-control" id="fiz_name" placeholder="z.B. Müller">
    </div>
    <div class="mb-3">
      <label for="fiz_name" class="form-label fw-bold">Geburtsdatum</label>
      <input type="text" class="form-control" id="fiz_date" placeholder="z.B.: 05.03.1995">
    </div>
    <div class="mb-3 text-center">
      <button id="btn_auth_submit" type="button" class="btn btn-success">anmelden</button>
      <button id="btn_auth_cancel" type="button" class="btn btn-danger">abbrechen</button>
    </div>
  </div>
</div>

<script type="text/javascript">
  fiz.auth = {};
  fiz.auth.setListeners = function()
  {
    a = document.getElementById('btn_auth_submit');
    a.addEventListener('click',function(){
      console.log('hallo!');
    });
   // a = document.getElementById('btn_auth_cancel');
   // a.addEventListener('click',function(){});
  }

  /**
   * prüft, ob die Formulareingaben syntaktisch dem geforderten entsprechen
   */
  fiz.auth.validateForm = function()
  {
    // authcode: 12 Zeichen, alphanumerisch
    // Nachname: Buchstaben, Leerzeichen, Bindestrich, Hochkomma 
    // geburtsdatum regex
    // ^(0?[1-9]|[12][0-9]|3[01])[\/\-.](0?[1-9]|1[012])[\/\-.]\d{4}$
    let formIsValid = true;

    let pattern = /\W/;
    let authcode = document.getElementById('fiz_auth').value;
    if(pattern.test(authcode) == true){ formIsValid =  false; }

    let nachname = document.getElementById('fiz_name').value;
    str = nachname.replace(/[ -\'_]/g,'');
    if(pattern.test(str) == true){ formIsValid =  false; }

    let gebdat = document.getElementById('fiz_date').value;






  }
  fiz.auth.emptyForm = function(){}


  fiz.auth.setListeners();
</script>
