export function sliders() {

  //Filtres double-range-sliders

  const slidersForm = document.querySelector(
    "#slidersForm"
  );
  console.log(slidersForm)

  const titleMin = document.getElementById("title-min");
  const titleMax = document.getElementById("title-max");

  const inputLeft = document.getElementById("input-left");
  const inputRight = document.getElementById("input-right");

  const dotLeft = document.getElementById("dot-left");
  const dotRight = document.getElementById("dot-right");

  const sliderRange = document.getElementById("slider-range");

  function setLeftValue() {
    let value = this.value;
    let min = parseInt(this.min);
    let max = parseInt(this.max);
    value = Math.min(parseInt(value), parseInt(inputRight.value) - 1);

    let percent = ((value - min) / (max - min)) * 100;

    sliderRange.style.left = percent + "%";
    dotLeft.style.left = percent + "%";
    titleMin.innerText = value;
  }
  function setRightValue() {
    let value = this.value;
    let min = parseInt(this.min);
    let max = parseInt(this.max);
    value = Math.max(parseInt(value), parseInt(inputLeft.value) + 1);

    let percent = ((value - min) / (max - min)) * 100;

    sliderRange.style.right = 100 - percent + "%";
    dotRight.style.right = 100 - percent + "%";
    titleMax.innerText = value;
  }
  inputLeft.addEventListener("input", setLeftValue);
  inputRight.addEventListener("input", setRightValue);
}
