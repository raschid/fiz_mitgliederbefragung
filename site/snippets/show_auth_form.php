<?php
    $authcode = '';
    $readonly = '';
/*
eRzYGK6yoZ0u
M5xm7LCFp14W
3QDaUb1zyiZs
bav6Bm2Eft0A
MkLcDXbgGKz5
*/

function returnJSONData($return) 
{
    //
}







/**
 * wenn der authcode im URL mitgeliefert wird, handelt es sich um den Aufruf über den Einladungslink
 * dann reicht es, das Formular nur mit ausgefülltem authcode auszugeben
 */
if($kirby->request()->is('GET'))
{
    if(!empty(get('authcode')))
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
<form name="fizUserAuth">
    <div class="ms-4 mt-3 mb-3 col-xs-8 col-sm-8 col-md-6 col-lg-5 alert alert-light" style="border:1px solid #ccc;border-radius:15px;">
        <h5 class="mt-3 mb-3">Als Mitglied authentifizieren:</h5>
        <div class="mb-3">
          <label for="fiz_auth" class="form-label fw-bold">Authentifizierungscode</label>
          <input type="text" class="form-control" name="authcode" id="fiz_auth" placeholder="Code aus der Einladungsmail" value="<?= $authcode; ?>"<?= $readonly; ?>>
        </div>
        <div class="mb-3">
          <label for="fiz_name" class="form-label fw-bold">Nachname</label>
          <input type="text" name="nachname" class="form-control" id="fiz_name" placeholder="z.B. Müller">
        </div>
        <div class="mb-3">
          <label for="fiz_name" class="form-label fw-bold">Geburtsdatum</label>
          <input type="text" name="geburtstag" class="form-control" id="fiz_date" placeholder="z.B.: 05.03.1995">
        </div>
        <div class="mb-3 text-center">
          <button id="btn_auth_submit" type="button" class="btn btn-success">anmelden</button>
        </div>
    </div>
</form>
</div>

<script type="text/javascript">
const a = document.getElementById('btn_auth_submit');
a.addEventListener('click',function(){
    if ( validateForm() ){

        let form = document.fizUserAuth.elements;
        let data = {};
        data.content = {}; 
        data.action = 'fizUserAuth';
        data.content.authcode = form.authcode.value;
        data.content.nachname = form.nachname.value;
        data.content.geburtstag = form.geburtstag.value;
        getDataFromServer(data)
        .then(data => {
            if(typeof data == 'string'){ data = JSON.parse(data); } // just in case ...
            switch(data.status)
            {
                case 'success': 
                    document.getElementById('main_content').innerHTML = data.pollform;
                    break;
                case 'error': 
                    showModal({titel:data.titel,body:data.message,bgcolor:'bg-danger-light'});
                    console.log(data); 
                    break;
            }
        });
    }
    else {
        let formError = { 
            titel: 'Fehler im Formular',
            body:'<ul><li>Groß- / Kleinschreibung sind wichtig!</li><li>schreibe Deinen Nachnamen so, wie er in der EMail geschrieben steht</li><li>schreibe dein Geburtsdatum im Format <i>01.07.2022</i>',
            bgcolor:'bg-danger-light'};
        showModal(formError);
    };
});

validateForm = function(){
    let formIsValid = true;

    let pattern = /\W/; // alle nicht-Wort-Zeichen. (allerdings auch äüß und so weiter...)
    let authcode = document.getElementById('fiz_auth').value;
    if(pattern.test(authcode) == true || authcode.length != 12 ){ formIsValid =  false; }

    let nachname = document.getElementById('fiz_name').value;
    if (nachname.length < 2){ formIsValid =  false; }

    let gebdat = document.getElementById('fiz_date').value;
    pattern= new RegExp('[0-9]{1,2}[.][0-9]{1,2}[.][0-9]{4}');
    if(!pattern.test(gebdat) || gebdat.length != 10){ formIsValid = false}

    return formIsValid;
}

</script>
