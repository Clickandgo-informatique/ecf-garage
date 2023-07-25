window.onload = () => {
  //Filtres de type input
  const filtersForm = document.querySelector("#filters");

  document.querySelectorAll("#filters input").forEach((input) => {
    if (input.className != "btn-collapse") {
      input.addEventListener("change", () => {
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
              history.pushState(
                {},
                null,
                Url.pathname + "?" + Params.toString()
              );
            })
            .catch((e) => alert(e));
        } else {
          alert("Le champ de filtre ne peut pas être laissé vide !");
          // input.value = 0;
        }
      });
    }
  });

  //Affiche le menu de filtres lateral gauche
  const showfilters = document.querySelector("#show-filters");
  
  showfilters.addEventListener("change", () => {
    if (showfilters.checked) {
      filtersForm.style.display = "flex";  
    } else {    
      filtersForm.style.display = "none";     
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
  //Collapse les containers d'input

  //Contrôle des saisies
  const yearMin = document.querySelector("#yearMin");
  const yearMax = document.querySelector("#yearMax");
  const yearMinValue = yearMin.value;
  const yearMaxValue = yearMax.value;

  yearMin.addEventListener("input", (e) => {
    e.preventDefault;
    const controlYearMin = () => {
      if (yearMin.value.length === 4 && yearMin.value > yearMax.value) {
        alert("L'année de départ ne peut être supérieure à l'année maximale");
        yearMin.value = yearMinValue;
      }
    };
    setTimeout(controlYearMin, 1000);
  });

  yearMax.addEventListener("input", (e) => {
    e.preventdefault;
    const controlYearMax = () => {
      if (yearMax.value.length === 4 && yearMax.value < yearMin.value) {
        alert("L'année maximale ne peut être inférieure à l'année de départ");
        yearMax.value = yearMaxValue;
      }
    };
    setTimeout(controlYearMax, 1000);
  });
};
