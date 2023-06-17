window.onload = () => {
  document.querySelectorAll("[data-reply]").forEach((element) => {
    element.addEventListener("click", function () {
        console.log(this)
      document.querySelector("#commentaires_parentid").value = this.dataset.id;
    });
  });
};
