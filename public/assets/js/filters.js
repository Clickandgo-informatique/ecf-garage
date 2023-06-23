window.onload = () => {
  //Filtres de type input
  const filtersForm = document.querySelector("#filters");

  document.querySelectorAll("#filters input").forEach((input) => {
    input.addEventListener("input", () => {
      if (input.value !== "" && input.value !== null) {
        //Récupération des données du formulaire
        const Form = new FormData(filtersForm);

        //Création de la queryString
        const Params = new URLSearchParams();

        Form.forEach((value, key) => {
          Params.append(key, value);
        });

        //Récupération de l'url active
        const Url = new URL(window.location.href);

        //Lancement requête Ajax

        fetch(Url.pathname + "?" + Params.toString() + "&ajax=1", {
          headers: {
            "X-Requested-With": "XMLHttpRequest",
          },
        })
          .then((response) => response.json())
          .then((data) => {
            //Recherche de la zone de contenu
            const content = document.querySelector("#content");

            //Remplacement du contenu
            content.innerHTML = data.content;

            //Mise à jour de l'url
            history.pushState({}, null, Url.pathname + "?" + Params.toString());
          })
          .catch((e) => alert(e));
      } else {
        alert("Le champ de filtre ne peut pas être laissé vide !");
        input.value = 0;
      }
    });
  });

  //Affiche le menu de filtres lateral gauche
  const showfilters = document.querySelector("#show-filters");

  showfilters.addEventListener("change", () => {
    if (showfilters.checked) {
     
      filtersForm.style.transform = "translateX(0px)";
      filtersForm.style.transition = "transform ease-in-out 2s";
      setTimeout(function collapse(){
        filtersForm.style.display="block"
      },2100)      

    } else {
      filtersForm.style.transform = "translateX(-100%)";
      filtersForm.style.transition = "transform ease-in-out 2s";
      setTimeout(function collapse(){
        filtersForm.style.display="none"
      },3100)
    }
  });
};
