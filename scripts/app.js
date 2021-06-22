const menu = document.getElementById("menu");
const menu_cls_btn = document.getElementById("menu-cls-btn");

const overlayAlertContainer = document.getElementById(
  "overlay-alert-container"
);
const overlayAlert = document.getElementById("overlay-alert");
const overlayAlertCloseBtn = document.getElementById("overlay-alert-close");

let nav_profile_picture = document.getElementById("nav-profile-picture");
if (nav_profile_picture == null) {
  nav_profile_picture = document.getElementById("nav-profile-picture-temp");
}
const fader = document.querySelector(".fader");

const menu_options = document.querySelectorAll(".menu-option");

const teams = document.querySelector(".teams");

if(overlayAlertCloseBtn != null){
overlayAlertCloseBtn.addEventListener("click", () => {
  overlayAlertContainer.style.opacity = 0;
  overlayAlertContainer.style.pointerEvents = "none";
});
}

if (nav_profile_picture != null && fader != null) {
  nav_profile_picture.addEventListener("click", () => {
    menu.style.transform = "translateX(0%)";
    fader.style.opacity = 1;
    fader.style.pointerEvents = "all";
  });
}

menu_cls_btn.addEventListener("click", () => {
  menu.style.transform = "translateX(100%)";
  fader.style.pointerEvents = "none";
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

