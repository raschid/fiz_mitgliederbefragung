<?php
/**
 * dieses snippet erzeugt für die in der Seite enthaltenen Fragen das entsprechende Formular! 
 *
 */

function createPoll()
{
  $radioNames = array();

  $pollcontainer ='<div id="pollcontainer" class="col-12 p-5"><form id="fizPoll22" action="/danke" method="post"><input type="hidden" id="radioNames" value="##RADIONAMES##">##CONTENT##</form>##SUBMIT##</div>'.getJavascript();

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

    // radioNames sammeln!
    if( !in_array( $question->qid(), $radioNames ) )
    { 
      array_push($radioNames, $question->qid());
    }



    $itembody = '<div class="border border-dark p-4 mb-5 qbody" style="border-top: 0px !important;">'.$beschlussvorschlag.$radio.'</div>';

    $temp .= $itembody;

    $content .= $temp;

    $itemnumber ++;
  }

  $radioNames = implode(',',$radioNames);

  // Submit-Button:
  $submit = '<div><button id="sbmtbtn" type="button" class="btn btn-success">Fragebogen abschicken</button></div>';

  $pollcontainer = str_replace(['##RADIONAMES##','##CONTENT##', '##SUBMIT##'], [$radioNames, $content, $submit], $pollcontainer);
  return $pollcontainer;

}




function makeRadioGroup($id)
{

$templ = <<< EOF
<div class="form-check">
  <input class="form-check-input" type="radio" name="##NAME##" value="##VALUE##">
  <label class="form-check-label" for="##ID##">
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

function getJavascript(){
$javascript = <<<EOD
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

    c = document.getElementById('sbmtbtn');
    c.addEventListener('click', function(){
        areAllRadiosChecked();

        if ( !allRadiosAreChecked ){
            d = {};
            d.titel = 'Formular unvollständig!';
            d.body = 'Es muss zu jeder Frage eine Antwort angeklickt sein!';
            d.bgcolor = 'bg-warning-light';
            showModal(d);
            allRadiosAreChecked = true;
        }
        else{ document.forms[0].submit(); }
    });

    var allRadiosAreChecked = true;

    areAllRadiosChecked = function(){
        let a = document.getElementById('radioNames').value;
        let b = a.split(',');
        for(i=0;i<b.length;i++) {
            a = document.querySelector('input[name="' + b[i] +'"]:checked');
            if ( a == 'null' || a == undefined){ allRadiosAreChecked = false; }
        }
    }
</script>
EOD;

return $javascript;
}

?>