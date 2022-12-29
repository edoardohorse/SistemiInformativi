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

function initWrapperNotifiche(){
  document.getElementById("notifica_icon").addEventListener('click', toggleWrapperNotifiche);

  document.getElementById("notifiche_new").addEventListener("click", mostraNuoveNotifiche);
  document.getElementById("notifiche_old").addEventListener("click", mostraVecchieNotifiche);
}

function mostraNuoveNotifiche(){
  document.getElementById("notifiche_new").classList.add("notifiche-selected")
  document.getElementById("nuoveNotifiche_wrapper").classList.add("notifiche_wrapper-selected")
  document.getElementById("notifiche_old").classList.remove("notifiche-selected")
  document.getElementById("vecchieNotifiche_wrapper").classList.remove("notifiche_wrapper-selected")
}
function mostraVecchieNotifiche(){
  document.getElementById("notifiche_old").classList.add("notifiche-selected")
  document.getElementById("vecchieNotifiche_wrapper").classList.add("notifiche_wrapper-selected")
  document.getElementById("notifiche_new").classList.remove("notifiche-selected")
  document.getElementById("nuoveNotifiche_wrapper").classList.remove("notifiche_wrapper-selected")
}

function toggleWrapperNotifiche(){
  const w = document.getElementById("notifica_content")
  if (w.classList.contains("notifica_content-show")) {
    w.classList.remove("notifica_content-show");
  } else {
    w.classList.add("notifica_content-show");
  }
}

function leggiNotifiche(){
  if(confirm('Sicuro di voler leggere tutte le notifiche?')){
    window.location.href='/SistemiInformativi/legginotifica?tutte';
  }
}

function cancellaNotificheLette(){
  if(confirm('Sicuro di voler cancellare tutte le notifiche già lette?')){
    window.location.href='/SistemiInformativi/cancellanotifica?tutte';
  }
}

window.addEventListener('load', function(){
  initWrapperAnnunci()  
  initVotoInput()
  initWrapperNotifiche()
  initWrapperFiltri()
})



function initWrapperFiltri() {
  let wrapperAnnunci = {}

  Array.from(document.querySelectorAll(".annunci")).forEach(wrapperAnnuncio=>{
    const annunci = Array.from(wrapperAnnuncio.querySelectorAll(".annuncio"))
    wrapperAnnunci[wrapperAnnuncio.title] = {
      "dati": annunci,
      "filtri": [],
      "datiFiltrati": annunci
      }     

    annunci.forEach(annuncio=>{
       wrapperAnnunci[wrapperAnnuncio.title]["filtri"].push(getInfoDaAnnuncio(annuncio))      
    })
  })
  
  console.log(wrapperAnnunci);

}

function getInfoDaAnnuncio(annuncio){
  return {
    "data": new Date(annuncio.querySelector("div.data").textContent),
    "luogo": annuncio.querySelector("div.luogo").textContent,
    "tempistica": annuncio.querySelector("div.tempistica").textContent
  }
}


function filtra(){}