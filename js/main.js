function openModal(id){
    document.getElementById(id).classList.remove('hide');
    document.querySelector('#modal_wrapper').classList.add('modal-shown');
}

function closeModal() {
    document.querySelector("#modal_wrapper .modal:not(.hide)").classList.add("hide");
  document.querySelector("#modal_wrapper").classList.remove("modal-shown");
}