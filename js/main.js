function openModal(id){
  document.getElementById(id).classList.remove('hide');
  document.querySelector('#modal_wrapper').classList.add('modal-shown');
  document.body.style.overflow = "hidden";
}

function closeModal() {
  document.querySelector("#modal_wrapper .modal:not(.hide)").classList.add("hide");
  document.querySelector("#modal_wrapper").classList.remove("modal-shown");
  document.body.style.overflow = "auto";
}

function switchWrapperAnnunci(titleToSelect){
    document.querySelector('#wrapper_annunci .title--selected').classList.remove('title--selected');
    this.classList.add('title--selected');
    document.querySelector(`#wrapper_annunci .annunci--selected`).classList.remove("annunci--selected");
    document.querySelector(`#wrapper_annunci .annunci[title="${this.title}"]`).classList.add("annunci--selected");
    
}

window.addEventListener('load', function(){
  Array.from(document.querySelectorAll('.titles h2')).forEach(title=>{
    // counter degli annunci per ogni categoria
    const nAnnunci = document.querySelectorAll(`#wrapper_annunci .annunci[title="${title.title}"] .annuncio`).length
    title.textContent = `${title.title} (${nAnnunci})`
    title.addEventListener('click', switchWrapperAnnunci.bind(title))
  })
})
