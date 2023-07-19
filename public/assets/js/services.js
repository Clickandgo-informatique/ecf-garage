window.onload = () => {
    console.log("coucou depuis service.js")
  //Active ou désactive l'affichage d'un service'
  let afficher = document.querySelectorAll(".toggle-switch-afficher");

  for (let checkbox of afficher) {
    checkbox.addEventListener("click", function () {
      let xmlhttp = new XMLHttpRequest();

      xmlhttp.open(
        "get",
        `/admin/services/afficher-service/${this.dataset.id}`
      );
      xmlhttp.send();
    });
  }
};
