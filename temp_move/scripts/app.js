const menu = document.getElementById("menu");
const menu_cls_btn = document.getElementById("menu-cls-btn");

const nav_profile_picture = document.getElementById("nav-profile-picture");
const fader = document.querySelector(".fader");

const menu_options = document.querySelectorAll(".menu-option");

const fav_action_btn = document.querySelector(".fav-title i");
const nav_joueur = document.querySelector("#nav-joueur");
const teams = document.querySelector(".teams");

const saved_action_btn = document.querySelector(".saved-title i");
const saved_matches = document.querySelector(".saved-matches");

nav_profile_picture.addEventListener("click", () => {
  menu.style.transform = "translateX(0%)";
  fader.style.opacity = 1;
});

menu_cls_btn.addEventListener("click", () => {
  menu.style.transform = "translateX(100%)";
  fader.style.opacity = 0;
});

menu_options.forEach((menu_option) => {
  menu_option.addEventListener("click", () => {
    removeClasses(menu_options, "highlighted-menu");
    menu_option.classList.add("highlighted-menu");
  });
});

function removeClasses(items, className) {
  items.forEach((item) => {
    item.classList.remove(className);
  });
}

fav_action_btn.addEventListener("click", () => {
  if (fav_action_btn.classList.contains("fa-minus")) {
    teams.style.height = "0px";
    teams.style.opacity = "0";
    fav_action_btn.className = "fas fa-plus";
  } else {
    teams.style.height = "200px";
    teams.style.opacity = "1";
    fav_action_btn.className = "fas fa-minus";
  }
});

saved_action_btn.addEventListener("click", () => {
  if (saved_action_btn.classList.contains("fa-minus")) {
    saved_matches.style.height = "0px";
    saved_matches.style.opacity = "0";
    saved_action_btn.className = "fas fa-plus";
    saved_action_btn.style.transform = "rotateZ(0deg)";
  } else {
    saved_matches.style.height = "200px";
    saved_matches.style.opacity = "1";
    saved_action_btn.className = "fas fa-minus";
    saved_action_btn.style.transform = "rotateZ(180deg)";
  }
});

nav_joueur.addEventListener("click", () => {
  menu.style.transform = "translateX(0%)";
  fader.style.opacity = 1;
  saved_matches.style.height = "200px";
  saved_matches.style.opacity = "1";
  saved_action_btn.className = "fas fa-minus";
  saved_action_btn.style.transform = "rotateZ(180deg)";
});
