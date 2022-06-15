<?php
$template = <<<EOD
  <div class="accordion-item">
    <h2 class="accordion-header" id="heading##ITEMNUMBER##">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#carousel##ITEMNUMBER##" aria-expanded="true" aria-controls="collapseOne">##ITEMTITLE##</button>
    </h2>
    <div id="carousel##ITEMNUMBER##" class="accordion-collapse collapse" aria-labelledby="heading##ITEMNUMBER##" data-bs-parent="#fiz_umfrage">
      <div class="accordion-body">
        ##ITEMBODY##
      </div>
    </div>
  </div>
EOD;



$questions = $page->questions()->toStructure();

echo '<div class="accordion" id="fiz_umfrage">';

$counter = 1;

foreach ($questions as $question)
{
  $t = $template;
  $itemnumber = $counter;
  $itemtitle = 'Frage '.$itemnumber.': '.$question->qtext()->html();
  print str_replace(['##ITEMTITLE##','##ITEMNUMBER##'],[$itemtitle,$itemnumber],$t);

  $counter ++;
}

echo '</div>';
?>