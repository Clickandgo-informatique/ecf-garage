console.log("coucou depuis Notification.js");
//chercher toutes les étoiles
const stars = document.querySelectorAll(".etoile");
//Chercher l'input
const note = document.querySelector("#commentaires_note");
//Boucle sur les étoiles
for (star of stars) {
  star.addEventListener("mouseover", function () {
    resetStars();
    this.style.color = "red";
    this.classList.add("fa-solid");
    this.classList.remove("fa-regular");
    //Elément précédent de même niveau dans le dom
    let previousStar = this.previousElementSibling;

    while (previousStar) {
      previousStar.style.color = "red";
      previousStar.classList.add("fa-solid");
      previousStar.classList.remove("fa-regular");
      previousStar = previousStar.previousElementSibling;
    }
  });
  //Ecoute du click
  star.addEventListener("click", function () {
    note.value = this.dataset.value;
  });

  star.addEventListener("mouseout", function () {
    resetStars(note.value);
  });
}

function resetStars(note = 0) {
  for (star of stars) {
    if (star.dataset.value > note) {
      star.style.color = "black";
      star.classList.add("fa-regular");
      star.classList.remove("fa-solid");
    } else {
      star.style.color = "red";
      star.classList.add("fa-solid");
      star.classList.remove("fa-regular");
    }
  }
}
