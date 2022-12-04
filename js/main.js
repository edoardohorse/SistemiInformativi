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

function initWrapperAnnunci(){
  Array.from(document.querySelectorAll('.titles h2')).forEach(title=>{
    // counter degli annunci per ogni categoria
    const nAnnunci = document.querySelectorAll(`#wrapper_annunci .annunci[title="${title.title}"] .annuncio`).length
    title.textContent = `${title.title} (${nAnnunci})`
    title.addEventListener('click', switchWrapperAnnunci.bind(title))
  })
}

function initVotoInput() {
  Array.from(document.querySelectorAll(".voto:not(.readonly) .stella")).forEach(
    (div) => {
      div.addEventListener("click", onClickStella.bind(div));
    }
  );

}

function onClickStella() {
  this.parentElement.querySelector("input[type=hidden]").value = this.dataset.value;
  document.querySelector(".stella.selected").classList.remove("selected");
  this.classList.add("selected");
}

function sendForm(e){
  e.preventDefault();
  // debugger

  fetch(this.action, {
    method: 'POST',
    body: new FormData(this)
  })
  .then(response => response.json())
  .then(data=>{
    closeModal()
    showNotification(data)
  });

  // console.log(result);
}

function showNotification(data){
  const notificationEl = newNotification(data)

  setTimeout(_=>{
    document.getElementById("wrapperNotification").removeChild(notificationEl);
  },5000)

  document.getElementById("wrapperNotification").appendChild(notificationEl)
}

function newNotification(data){
  let wrapper       = document.createElement("div")
  let messageEl     = document.createElement("span")
  let redirectBtn   = document.createElement("button")
  let redirectLink  = document.createElement("a")

  
  messageEl.textContent = data.message

  const state = data.success? "success": "failed"
  wrapper.classList.add("notification",state)
  wrapper.appendChild(messageEl)
  
  if(data.redirectUrl){
    redirectLink.href = data.redirectUrl;
    redirectBtn.textContent = "Vedi";

    redirectLink.appendChild(redirectBtn);
    wrapper.appendChild(redirectLink);
  }

  return wrapper
}



window.addEventListener('load', function(){
  initWrapperAnnunci()  
  initVotoInput()
  Array.from(document.querySelectorAll('form')).forEach(form=>{
    form.addEventListener('submit', sendForm.bind(form))
  })
})

