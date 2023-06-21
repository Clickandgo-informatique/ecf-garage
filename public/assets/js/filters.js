window.onload = () => {
  //Filtres de type input
  const filtersForm = document.querySelector("#filters");

  document.querySelectorAll("#filters input").forEach((input) => {
    
    input.addEventListener("input", () => {
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
    });
  });
};
