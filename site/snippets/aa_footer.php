
	</div>
<div style="display:block;width:100%;height:50px;"></div>


<!-- modal-template -->
<div class="modal fade" id="fizModal" tabindex="-1" aria-labelledby="fizLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="fizModalTitel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="fizModalBody"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">schließen</button>
      </div>
    </div>
  </div>
</div>

<script>
	const fizModal = new bootstrap.Modal('#fizModal', {});
	b = document.getElementById('fizModal');
	b.addEventListener('hide.bs.modal', event => { emptyModal(); })

/**
 * zeigt das Modal mit dem gewünschten Inhalt an:
 * @param object { titel: '...',body:'...',bgcolor:'bg-warning-light'};
 */
	function showModal(content){
		document.getElementById('fizModalTitel').innerHTML = '<h4>' + content.titel + '</h4>';
		document.getElementById('fizModalBody').innerHTML = content.body;
		document.querySelector('.modal-content').classList.add(content.bgcolor);
		fizModal.show();
	}
/**
 * setzt Modal in leeren Zustand zurück und entfernt Hintergrundfarbe
 * @param void
 */
	function emptyModal(){
		document.getElementById('fizModalTitel').innerHTML = '';
		document.getElementById('fizModalBody').innerHTML = '';
		let el = document.querySelector('.modal-content');
		el.classList.remove('bg-warning-light', 'bg-danger-light', 'bg-success-light', 'bg-light');
		document.querySelector('.modal-dialog').classList.remove('modal-fullscreen');
		document.querySelector('.modal-dialog').classList.remove('modal-small');
	}
/**
 * holt die angefragten Daten vom Server
 * @param object	what { action: '...', content: {...} };
 */
async function getDataFromServer(data)
{
	const response = await fetch('/home.json', {
  		method: 'POST',
  		headers: { 'Content-Type': 'application/json' },
  		body: JSON.stringify(data)
	});
	return response.json();
}
</script>

</body>
</html>