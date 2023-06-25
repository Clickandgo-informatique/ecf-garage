window.onload = () => {
  document.querySelectorAll("[data-reply]").forEach((element) => {
    element.addEventListener("click", function () {
      console.log(this);
      document.querySelector("#commentaires_parentid").value = this.dataset.id;
    });
  });

  //Active ou désactive la publication d'un commentaire utilisateur
  let publier = document.querySelectorAll(".toggle-switch-publier");

  for (let checkbox of publier) {
    checkbox.addEventListener("click", function () {
      let xmlhttp = new XMLHttpRequest();

      xmlhttp.open(
        "get",
        `/admin/commentaires/publier-commentaire/${this.dataset.id}`
      );
      xmlhttp.send();
    });
  }

  //Demande confirmation à la suppression du commentaires actuel
  const tblCommentaires=document.getElementById("tblCommentaires")

tblCommentaires.addEventListener("click", (e) => {
    e.preventdefault;
    if (e.target.id === "btn-supprimer-commentaire") {
      if (
        confirm(
          "Etes vous sûr de vouloir effacer ce commentaire utilisateur ?."
        )
      ) {
        const id = e.target.getAttribute("data-id");

        fetch(`/admin/commentaires/supprimer-commentaire/${id}`, {
          method: "DELETE",
        })
          .then((response) => window.location.reload())
          .catch((error) => error.message);
      }
    }
  });
};
