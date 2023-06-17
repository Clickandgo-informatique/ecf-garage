window.onload = () => {
  //Active ou désactive la publication d'une fiche véhicule en tant qu'annonce
    let publier = document.querySelectorAll(".publication-annonce");
  
    for (let checkbox of publier) {
      checkbox.addEventListener("click", function () {
        let xmlhttp = new XMLHttpRequest();
        xmlhttp.open("get",`/vehicules/annonces/publier-annonce/${this.dataset.id}`)
        xmlhttp.send()
      });
    }
  };