window.onload = () => {

  //Filtres de type input
  const filtersForm = document.querySelector("#filters");

  document.querySelectorAll("#filters input").forEach((input) => {
    input.addEventListener("change", () => {
      // if(input.type =="number"){

      // }
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
        // input.value = 0;
      }
    });
  });

  //Affiche le menu de filtres lateral gauche
  const showfilters = document.querySelector("#show-filters");
  const wrapperfiltres = document.querySelector(".wrapper-filtres");

  showfilters.addEventListener("change", () => {
    if (showfilters.checked) {
      wrapperfiltres.style.width = "220px";
      // document.querySelector(".wrapper").style.marginLeft = "220px";
      wrapperfiltres.style.transition = "ease-in 1s";
      wrapperfiltres.style.display = "block";
    } else {
      wrapperfiltres.style.width = "0px";
      // document.querySelector(".wrapper").style.marginLeft = "0px";
      wrapperfiltres.style.transition = "ease-out 1s";
      wrapperfiltres.style.display = "none";
    }
  });

  function debounce(cb, delay = 1000) {
    let timeout;

    return (...args) => {
      clearTimeout(timeout);
      timeout = setTimeout(() => {
        cb(...args);
      }, delay);
    };
  }
};
