<?php
/**
 * dieses snippet erzeugt für die in der Seite enthaltenen Fragen das entsprechende Formular! 
 *
 */


function get_bootstrap_accordion()
{
  // Template für bootstrap-accordion
  $template = <<<EOA
  <div class="accordion-item">
    <h2 class="accordion-header" id="heading##ITEMNUMBER##">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#carousel##ITEMNUMBER##" aria-expanded="true" aria-controls="collapseOne">##ITEMTITLE##</button>
    </h2>
    <div id="carousel##ITEMNUMBER##" class="accordion-collapse collapse##SHOWITEM##" aria-labelledby="heading##ITEMNUMBER##" data-bs-parent="#fiz_umfrage">
      <div class="accordion-body">
        ##ITEMBODY##
      </div>
    </div>
  </div>
  EOA;

  // letzter Eintrag des Akkordeons: dient zum abschicken des Formulars 
  $submit = <<<EOA
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingSubmit">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#carouselSubmit" aria-expanded="true" aria-controls="collapseOne">Umfrage abschicken</button>
    </h2>
    <div id="carouselSubmit" class="accordion-collapse collapse" aria-labelledby="headingSubmit" data-bs-parent="#fiz_umfrage">
      <div class="accordion-body">
        <button type="button" class="btn btn-primary">Umfrage abschicken</button>
        <button type="button" class="btn btn-danger">abbrechen</button>
      </div>
    </div>
  </div>
  EOA;

  // Style für Texte mit .callout-Klasse
  $callout = <<<EOB
  <style type="text/css">
    .callout {
      padding: 20px;
      margin: 20px 0;
      /*border: 1px solid #edfbfe;*/
      border: 1px solid #eee;
      border-left-width: 8px;
      /*border-left-color: #b5d4ff;*/
      border-left-color: #888;
      border-radius: 3px;
      background-color: #eee;
      /*background-color: #e7f1ff;*/

      /*.accordion-button:not(.collapsed)*/
      .accordion-header>h2 {
        color: #333 !important;
        background-color: #ff0000 !important;
      }
    }
  </style>
  EOB;

  // Inhalte von der Seite holen
  $questions = $page->questions()->toStructure();

  // Akkordeon und Formular starten
  echo '<div class="accordion mt-4 mb-4" id="fiz_umfrage">';
  echo '<form>';
  // CSS für callout einbinden
  echo $callout;

  // jetzt alle Fragen der Reihe nach ausgeben
  $itemnumber = 1;
  foreach ($questions as $question)
  {
    $t = $template;
    
    // dafür sorgen, dass nur der erste eintrag geöffnet ist
    $itemnumber < 2? $showitem = " show" : $showitem = '';
    $itemtitle = 'Frage '.$itemnumber.': '.$question->qtext()->html();

    $t = str_replace(['##ITEMTITLE##','##ITEMNUMBER##','##SHOWITEM##'],[$itemtitle,$itemnumber,$showitem],$t);
    $b = getItemBody_bootstrap($question,$itemnumber);
    $t = str_replace('##ITEMBODY##',$b,$t);

    print $t;
    $itemnumber ++;
  }
  print $submit;

  echo '</form></div>';
}

/**
 * wandelt die Antwortmöglichkeiten in checkboxes oder radiobuttons
 * itemnumber: nötig, um die IDs eindeutig zu machen!
 */
function getItemBody_bootstrap($question,$itemnumber)
{

/**
 *  Vorlagen für bootstrap 5 checkboxes und radiobuttons
 *  Die Platzhalter in doppelten Rauten (##OPTNUM##) müssen 
 *  im Programmverlauf ersetzt werden 
 */
  $tpl_checkbox = <<<EOD
  <div class="form-check">
    <input class="form-check-input" type="checkbox" value="##OPTVAL##" id="option##OPTNUM##">
    <label class="form-check-label" for="option##OPTNUM##">##OPTTEXT##</label>
  </div>
  EOD;

  $tpl_radio = <<<EOD
  <div class="form-check">
    <input class="form-check-input" type="radio" name="question##ITEMNUMBER##" id="option##OPTNUM##" val="##OPTVAL##">
    <label class="form-check-label" for="option##OPTNUM##">##OPTTEXT##</label>
  </div>
  EOD;

// nimmt das gesamte auszugebende HTML auf
  $return = '';

// gibt es vor den Kästchen noch Info-Text?
  $itemexplain = $question->qexplain()->kirbytext();
  if (strlen($itemexplain) > 2)
  {
    $explanation = '<div class="callout">'.$itemexplain.'</div>';
  }
  else { $explanation = '';}

  $return .= $explanation;

// weist $template die richtige Vorlage zu
  $question->qtype() == 'multiple'?  $template = $tpl_checkbox : $template = $tpl_radio;

// es handelt sich bei den Antwortmöglichkeiten um eine structure (in einer structure ...)
// deshalb muss das Object vorher umgewandelt werden!
  $replies = $question->qreplies()->toStructure();
  $counter = 1;

  foreach($replies as $reply)
  {
      $optnum = $itemnumber.$counter;
      $optval = $reply->value();
      $opttext = $reply->reply();

      $search = [
        '##OPTTEXT##',
        '##OPTVAL##',
        '##OPTNUM##'
      ];

      $replace = [
        $opttext,
        $optval,
        $optnum
      ];

      $t = str_replace($search, $replace, $template);

      if($question->qtype() == 'justone')
      {
        $t = str_replace('##ITEMNUMBER##',$itemnumber, $t);
      }

      $return = $return.$t;

      $counter ++;
  }

  return $return;
}



/*----------  ab hier: bootstrap tabs!  ----------*/
function get_bootstrap_carousel()
{
}










?>