function openModal(id){
    document.getElementById(id).classList.remove('hide');
    document.querySelector('#modal_wrapper').classList.add('modal-shown');
}

function closeModal() {
    document.querySelector("#modal_wrapper .modal:not(.hide)").classList.add("hide");
  document.querySelector("#modal_wrapper").classList.remove("modal-shown");
}

function switchWrapperAnnunci(titleToSelect){
    document.querySelector('#wrapper_annunci .title--selected').classList.remove('title--selected');
    this.classList.add('title--selected');
    document.querySelector(`#wrapper_annunci .annunci--selected`).classList.remove("annunci--selected");
    document.querySelector(`#wrapper_annunci .annunci[title="${this.title}"]`).classList.add("annunci--selected");
    
}

window.addEventListener('load', function(){
  Array.from(document.querySelectorAll('.titles h2')).forEach(title=>{
    title.addEventListener('click', switchWrapperAnnunci.bind(title))
  })
})
