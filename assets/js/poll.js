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