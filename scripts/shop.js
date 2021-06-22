Array.prototype.random = function () {
  return this[Math.floor(Math.random() * this.length)];
};

const buyBtns = document.querySelectorAll(".buy-btn");
const packedCardsContainer = document.querySelector(".packed-cards-container");
const packedCards = document.getElementById("packed-cards");
const packedCardsCls = document.getElementById("packed-cards-cls");
const mtPoints = document.getElementById("mt-points");

const overlayContainer = document.getElementById("overlay-container");
const overlay = document.getElementById("overlay");
const overlayCloseBtn = document.getElementById("overlay-close");
const overlayTitle = document.getElementById("overlay-title");
const overlayMessage = document.getElementById("overlay-message");

buyBtns.forEach((buyBtn) => {
  buyBtn.addEventListener("click", () => {
    buyPack(buyBtn.id.split("-")[1]);
  });
});

packedCardsCls.addEventListener("click", () => {
  hidePackedCards();
});

overlayCloseBtn.addEventListener("click", () => {
  overlayContainer.style.opacity = 0;
  overlayContainer.style.pointerEvents = "none";
});

function buyPack(id) {
  const xhr = new XMLHttpRequest();

  xhr.onload = () => {
    const response = JSON.parse(xhr.responseText);
    console.log(response);

    if (response.status) {
      packedCards.innerHTML = "";

      let packedCard = '<div class="packed-card">';
      packedCard += `<img src="${response.data[0].variantURL}" alt="" srcset="">`;
      packedCard += "</div>";

      packedCards.innerHTML = packedCard;
      mtPoints.innerHTML =
        "MT_POINTS : " + response.remainingPoints.toLocaleString();

      displayPackedCards();
    } else {
      if (response.message == "duplicate") {
        const overlayMesage = document.getElementById("overlay-message");
        console.log("refund : " + response.refund);
        overlayMesage.innerHTML =
          "Doublons de carte 😥, remboursement de " +
          response.refund +
          ' <span class="green">MT_POINTS</span>';
    mtpoints.innerhtml =
        "mt_points : " +
        (response.remainingpoints + response.refund).tolocalestring();

      }
      overlayContainer.style.opacity = 1;
      overlayContainer.style.pointerEvents = "auto";
    }
  };

  const data = new FormData();
  data.append("id", id);

  xhr.open("POST", "shop_ajax.php", true);
  xhr.send(data);
}

function displayPackedCards() {
  packedCardsContainer.style.opacity = 1;
  packedCardsContainer.style.pointerEvents = "auto";
}

function hidePackedCards() {
  packedCardsContainer.style.opacity = 0;
  packedCardsContainer.style.pointerEvents = "none";
}
