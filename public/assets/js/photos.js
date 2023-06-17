//Suppression d'une photo
let links = document.querySelectorAll("[data-delete]");

for (let link of links) {
  link.addEventListener("click", function (e) {
    e.preventDefault();
    //Demande de confirmation suppression
    if (confirm("Voulez-vous vraiment effacer cette photo de la base ?")) {
      fetch(this.getAttribute("href"), {
        method: "DELETE",
        headers: {
          "X-Requested-With": "XMLHttpRequest",
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ _token: this.dataset.token }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            this.parentElement.remove();
          } else {
            alert(data.error);
          }
        });
    }
  });
}

//Agrandissement d'une photo
let photos = document.getElementsByClassName("thumbnail-vehicule");

for (let photo of photos) {
  photo.addEventListener("mousemove", (e) => {
    photo.style.transform = "scale(3)";
    photo.style.transition = "transform";
    photo.style.transitionDuration = "0.5s";
    photo.style.zIndex = "300";
  });
  photo.addEventListener("mouseout", (e) => {
    photo.style.transform = "scale(1)";
    photo.style.transition = "transform";
    photo.style.transitionDuration = "1s";
    photo.style.zIndex = "1";
  });
}
