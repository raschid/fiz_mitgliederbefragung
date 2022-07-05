<?php
/**
 * dieses snippet erzeugt für die in der Seite enthaltenen Fragen das entsprechende Formular! 
 *
 */

function createPoll()
{

  $pollcontainer ='<div id="pollcontainer" class="col-12 p-5"><form id="fizPoll22">##CONTENT##</form>##SUBMIT##</div>##JAVASCRIPT##';

  // Inhalte von der Seite holen
  $questions = kirby()->page('home')->questions()->toStructure();
  $itemnumber = 1;
  $content = '';

  // jetzt Daten zu jeder Frage holen
  foreach ($questions as $question)
  {
    $temp = '';

    $itemtitel = 'Frage '.$itemnumber.': '.$question->qtext()->html();
    $itemexplain = $question->qexplain()->kirbytext(); 
    $titelbtn = '<h5 style="width:30px;height:26px;" class="rounded-circle text-center text-light bg-primary titelbtn" data-titel="'.$itemtitel.'" data-explain="'.$itemexplain.'">?</h5>';

    // Titelzeile
    $temp .=  '<div class="bg-light border border-dark p-2 itemtitel"><h5>'.$itemtitel.'</h5>'.$titelbtn.'</div>';

    // Textkörper
    $beschlussvorschlag ='<h6>Beschlußvorschlag: '.$question->qproposal().'</h6>';
    $radio = makeRadioGroup($question->qid());
    $itembody = '<div class="border border-dark p-4 mb-5 qbody" style="border-top: 0px !important;">'.$beschlussvorschlag.$radio.'</div>';

    $temp .= $itembody;

    $content .= $temp;

  $itemnumber ++;
  }

  // Submit-Button:
  $submit = '<div><button type="button" class="btn btn-success">Fragebogen abschicken</button></div>';

$javascript = <<< EOD
  <script type="text/javascript">
    let a = document.querySelectorAll('.titelbtn');
    a.forEach((b) => {
      b.addEventListener('mouseover', function(){
        this.classList.remove('text-light', 'bg-primary');
        this.classList.add('text-dark', 'bg-warning');
        this.style.cursor = 'pointer';
      });
     b.addEventListener('mouseout', function(){
        this.classList.remove('text-dark', 'bg-warning');
        this.classList.add('text-light', 'bg-primary');
      });
     b.addEventListener('click', function(){
        document.querySelector('.modal-dialog').classList.add('modal-fullscreen');
        c = {};
        c.titel = this.dataset.titel;
        c.body = this.dataset.explain;
        c.bgcolor = 'bg-light';
        showModal(c);
      });
    });

  </script>
EOD;

  //$pollcontainer = str_replace(['##CONTENT##', '##SUBMIT##','##JAVASCRIPT##'], [$content, $submit, $javascript], $pollcontainer);
  $pollcontainer = str_replace(['##CONTENT##', '##SUBMIT##'], [$content, $submit], $pollcontainer);
  return $pollcontainer;

}


function makeRadioGroup($id){

$templ = <<< EOF
<div class="form-check">
  <input class="form-check-input" type="radio" name="##NAME##" id="##ID##">
  <label class="form-check-label" for="##ID##" value="##VALUE##">
    ##TEXT##
  </label>
</div>
EOF;

$values = ['','ja','nein','enthaltung'];
$text = ['','ja','nein','Enthaltung'];

  $radiogroup = '';

  for($i = 1; $i < 4; $i++)
  {
    $t = $templ;
    $t = str_replace(['##NAME##','##ID##','##VALUE##','##TEXT##'],[$id, $id.$i, $values[$i], $text[$i]], $t);
    $radiogroup .= $t;
  }

return $radiogroup;

}

?>