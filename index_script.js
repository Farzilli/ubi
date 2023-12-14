const list = document.querySelector("#list");
const items = document.querySelectorAll("#list .item");
const stopTime = 5000;

let active = 0;

function next() {
    active = active + 1 <= items.length - 1 ? active + 1 : 0;
    list.style.left = -items[active].offsetLeft + "px";
}

refreshInterval = setInterval(next, stopTime);
window.onresize = () => next();

const form = document.querySelector("#index_optionbar form");
const cinemaSelect = document.querySelector("#index_optionbar form #cinema");
const filmSelect = document.querySelector("#index_optionbar form #film");
const giornoSelect = document.querySelector("#index_optionbar form #giorno");
const orarioSelect = document.querySelector("#index_optionbar form #orario");

cinemaSelect.addEventListener("change", () => filmSelect.removeAttribute("disabled"));
filmSelect.addEventListener("change", () => giornoSelect.removeAttribute("disabled"));
giornoSelect.addEventListener("change", () => orarioSelect.removeAttribute("disabled"));
orarioSelect.addEventListener("change", () => form.submit());
