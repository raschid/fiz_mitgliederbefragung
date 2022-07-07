<?php
/**
 * zentrale Benutzer-Authentifizierung und Rechte-Verwaltung
 */

/**
 *
 * Wenn kein AJAX, dann prüfen, ob der User eingeloggt ist, sonst auf login-Seite umleiten 
 *
 */
if (!$kirby->user()) 
{ 
	go('login'); 
}
else
{
/**
 *
 * Hier entscheidet sich: was darf dieser eingeloggte User sehen?
 * mitglied:       für Umfrage
 * vorstand:       nur Umfragestatistik für Vorstandsmitglieder
 * administrator: alle Seiten
 *
 *
 * Was hier passiert:
 * sofern der aufrufende User kein admin ist, prüft der Code, ob der Rollenname des Benutzers
 * teil des URL ist. Wenn nicht, versucht der User eine Seite aufzurufen, die nicht seiner Rolle 
 * entspricht und wird wieder auf seine Rollen-Seite zurück geschickt.
 *
 * Seltsamer Weise muss ich für den strpos-Vergleich mit strval arbeiten. 
 * Kirby gibt sonst aus, dass es die Werte nicht in Integer umwandeln kann???
*/
  $user = $kirby->user();
  
  if(!$user->isAdmin()){
    $a = strval($page->url());
    $b = strval($user->role());
    $c = strpos($a,$b); 
    if( $c === false ) {
        go($site->url()."/".$user->role());
     }
  }
}