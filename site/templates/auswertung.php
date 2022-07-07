<?php
if (!$kirby->user()) { go('/login'); }

echo snippet('aa_header');
echo '<div class="row">';
echo '<div class="col-12">';
echo '<h1 class="mt-4" style="margin-bottom:3.0rem">'.$page->title().'</h1>';
echo '</div>';
echo '</div>';
echo '<div class="row" id="main_content">';
echo '<div class="col-12 fs-5">';

$datum = $d = date("d.m.Y H:m", time());
$tn_online_gesamt =  Db::count('mitglieder');
$tn_hatgewaehlt =  Db::count('mitglieder', 'hatgewaehlt > "2022-06-30 10:00:00"');


// jetzt die Ergebnisse für die einzelnen Fragen sammeln
$frage_ids = Db::query('SELECT DISTINCT frage_id  FROM `ergebnisse`;');
$trows = '';
foreach ($frage_ids as $id) {
	$sql = 'SELECT 
				SUM(wert="ja") AS ja, 
				SUM(wert="nein") AS nein, 
				SUM(wert="enthaltung") AS enth  
			FROM ergebnisse
			WHERE frage_id = "'.$id->frage_id().'";'; 

	$counts = Db::query( $sql );
	$m = $counts->toArray();

	$trow = '<tr>
      <td scope="col">##Q##</td>
      <td scope="col">##JA##</td>
      <td scope="col">##NEIN##</td>
      <td scope="col">##ENTH##</td>
    </tr>';

    $frageTitel = getQtitel($id->frage_id());

    $search = ['##Q##','##JA##','##NEIN##','##ENTH##'];
    $replace= [$frageTitel, $m[0]->ja(),$m[0]->nein(),$m[0]->enth()];

    $trow = str_replace($search, $replace,$trow);
 	$trows .= $trow;
}




echo '<table><tr><td style="width:350px;">Zeitpunkt der Abfrage:</td><td> '.$datum.'</td></tr>';
echo '<tr><td>Mitglieder in DB gesamt:</td><td>'.$tn_online_gesamt.'</td></tr>';
echo '<tr><td>Mitglieder die gewählt haben:</td><td> '.$tn_hatgewaehlt.'</td></tr></table>';
echo '<h4 class="mt-4">Ergebnisse:</h4>';


$tbody = getTable();
$table = str_replace('##TBODY##',$trows,$tbody);

echo $table;



?>

<?php 
echo '</div>';
echo snippet('aa_footer');


function getTable(){

$t = '
<table class="table table-bordered table-sm">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">ja</th>
      <th scope="col">nein</th>
      <th scope="col">Enthaltung</th>
    </tr>
  </thead>
  <tbody>
  ##TBODY##
  </tbody>
</table>';

return($t);

}


function getQtitel($frage_id)
{
// Inhalte von der Seite holen
  $questions = kirby()->page('home')->questions()->toStructure();

  // jetzt Titel zu jeder Frage holen
  foreach ($questions as $question)
  {
  	if($question->qid() == $frage_id)
  	{
	    return $question->qtext()->text();
  	}
  }
}

?>