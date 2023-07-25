const cookiesBanner = document.querySelector(".cookies-banner-fr");
const cookiesBannerAcceptButton = document.querySelector(".accept-cookies");
const cookiesBannerDeclineButton = document.querySelector(".decline-cookies");
const cookieName = "cookiesBanner";
const el = document.querySelector("main");
const body = document.querySelector("body");
window.onload = () => {
  //Annule momentanément le scrolling
  disableBodyScroll();
  //Affiche le banner de cookies si cookie inexistant
  cookiesBanner.classList.remove("closing");
  cookiesBanner.classList.add("opening");
  const hasCookie = getCookie(cookieName);
  if (!hasCookie) {
    cookiesBanner.classList.remove("hidden");
    cookiesBanner.classList.add("fadeIn");
  }

  //Mise en place de cookie si acceptation
  cookiesBannerAcceptButton.addEventListener("click", () => {
    setCookie(cookieName, "closed");
    cookiesBanner.classList.remove("fadeIn");
    cookiesBanner.classList.add("fadeOut");
    cookiesBanner.classList.remove("opening");
    cookiesBanner.classList.add("closing");

    //fait dispraître le banner de cookies après le fadeOut

    enableBodyScroll();

    setTimeout(() => {
      cookiesBanner.remove();
    }, 2000);
  });

  //Fermeture du banner de cookies si refus
  cookiesBannerDeclineButton.addEventListener("click", () => {
    enableBodyScroll();
    cookiesBanner.classList.remove("fadeIn");
    cookiesBanner.classList.remove("opening");
    cookiesBanner.classList.add("fadeOut");
    cookiesBanner.classList.add("closing");
    //fait disparaître le banner de cookies après le fadeOut
    // et autorise le scrolling
    setTimeout(() => {
      cookiesBanner.remove();
    }, 2000);
  });
 };
const getCookie = (name) => {
  const value = " " + document.cookie;
  const parts = value.split(" " + name + "=");
  return parts.length < 2 ? undefined : parts.pop().split(";").shift();
};

const setCookie = function (
  name,
  value,
  expiryDays,
  domain,
  path,
  secure,
  SameSite
) {
  const exDate = new Date();
  exDate.setHours(
    exDate.getHours() + (typeof expiryDays !== "number" ? 365 : expiryDays) * 24
  );

  document.cookie =
    name +
    "=" +
    value +
    "expires=" +
    exDate.toUTCString() +
    ";path=" +
    (path || "/") +
    (domain ? ";domain=" + domain : "") +
    (secure ? ";secure" : "") +
    (SameSite ? ";None" : "");
};

//Annuler scrolling du main

function disableBodyScroll() {
  el.classList.add("stop-scroll");
}

function enableBodyScroll() {
  el.classList.remove("stop-scroll");
}
