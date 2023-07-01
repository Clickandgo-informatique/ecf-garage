window.onload = () => {
  //Fonction qui anime les alertes de type flash
  const btnClose = document.querySelectorAll(".btn-close").forEach((button) => {
    button.addEventListener("click", (e) => {
      e.target.parentElement.style.webkitTransform = 'scale(0)';
      e.target.parentElement.style.msTransform = 'scale(0)';
      e.target.parentElement.style.mozTransform = 'scale(0)';
      e.target.parentElement.style.oTransform = 'scale(0)';
      e.target.parentElement.style.transform = 'scale(0)';

      e.target.parentElement.style.webkitTransition = 'transform 1s';
      e.target.parentElement.style.MozTransition = 'transform 1s';
      e.target.parentElement.style.msTransition = 'transform 1s';
      e.target.parentElement.style.oTransition = 'transform 1s';
      e.target.parentElement.style.transition = 'transform 1s';

      setTimeout(() => {
        e.target.parentElement.remove();
      }, 1100);
    });
  });
};
