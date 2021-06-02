const sign_in_btn = document.getElementById("sign-in-btn");
const sign_up_btn = document.getElementById("sign-up-btn");

const sign_container = document.querySelector(".sign-container");

sign_up_btn.addEventListener("click", () => {
  sign_container.classList.add("sign-up-mode");
});

sign_in_btn.addEventListener("click", () => {
  sign_container.classList.remove("sign-up-mode");
});

