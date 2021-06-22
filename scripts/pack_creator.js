window.addEventListener("DOMContentLoaded", () => {
  const searchBar = document.getElementById("pack-searchbar");

  const packCreatorPlayers = document.getElementById("pack-creator-players");
  const packPlayers = document.getElementById("pack-players");
  const clearBtn = document.getElementById("clear-btn");
  const createBtn = document.getElementById("create-btn");
  const packName = document.getElementById("name");
  const packPrice = document.getElementById("price");

  let players = [];
  let playerVariantIDs = [];
  let response = null;

  searchBar.addEventListener("keyup", () => {
    if (searchBar.value.length >= 2) search(searchBar.value);
    if (searchBar.value.length == 0) {
      packCreatorPlayers.innerHTML = "";
      players = [];
    }
  });

  createBtn.addEventListener("click", () => {
    createPack();
  });

  clearBtn.addEventListener("click", () => {
    packPlayers.innerHTML = "";
    playerVariantIDs = [];
  });

  window.addEventListener("keyup", (e) => {
    if (e.key === "Enter") {
      console.log(response);
    }
  });

  function search(query) {
    const xhr = new XMLHttpRequest();

    xhr.onload = () => {
      response = JSON.parse(xhr.responseText);
      packCreatorPlayers.innerHTML = "";
      players = [];
      updatePackCreatorPlayers();
    };

    const data = new FormData();

    data.append("query", query);

    xhr.open("POST", "create_pack_ajax.php", true);
    xhr.send(data);
  }

  function updatePackCreatorPlayers() {
    if (response.response.length > 0) {
      response.response.forEach((player) => {
        if (!players.includes(player.id)) {
          players.push(player.id);

          let newCard = document.createElement("div");
          newCard.className = "pack-creator-player";
          newCard.id = player.full_name;

          let newCardVariants = document.createElement("div");
          newCardVariants.className = "pack-creator-player-variant";
          newCardVariants.id = player.id;

          newCardVariants.innerHTML += `<h1>${player.full_name}</h1>`;
          let newPlayerCardImage = document.createElement("img");
          newPlayerCardImage.src = player.variantURL;
          newPlayerCardImage.alt = player.full_name + "-" + player.variant;

          newCardVariants.appendChild(newPlayerCardImage);

          newCard.appendChild(newCardVariants);
          packCreatorPlayers.appendChild(newCard);

          newPlayerCardImage.addEventListener("click", () => {
            addCardToPack(player);
          });
        } else {
          let playerCard = document.getElementById(player.id);
          let newPlayerCard = document.createElement("img");
          newPlayerCard.src = player.variantURL;
          newPlayerCard.alt = player.full_name + "-" + player.variant;

          newPlayerCard.addEventListener("click", () => {
            addCardToPack(player);
          });

          playerCard.appendChild(newPlayerCard);
        }
      });
    }
  }

  function addCardToPack(player) {
    if (document.getElementById(player.id + "-" + player.variant) != null) {
      return false;
    }

    let newPackPlayer = `<div class="pack-player" id="${player.id}-${player.variant}">`;
    newPackPlayer += `    <img src="${player.variantURL}" alt="player headshot"/>`;
    newPackPlayer += `    <p>${player.full_name}</p>`;
    newPackPlayer += `   <p>N°${player.variant}</p>`;
    newPackPlayer += `<i class="fas fa-times" id="close-${player.id}-${player.variant}"></i>`;
    newPackPlayer += "</div>";

    packPlayers.innerHTML += newPackPlayer;

    playerVariantIDs.push(player.vid);

    document
      .getElementById("close-" + player.id + "-" + player.variant)
      .addEventListener("click", (e) => {
        packPlayers.removeChild(e.target.parentElement);
        console.log("remove card");
      });
  }

  function createPack() {
    if (
      packPlayers.children.length == 0 ||
      packName.length == 0 ||
      packPrice <= 0
    ) {
      console.log("empty inputs");
      return false;
    }

    const xhr = new XMLHttpRequest();

    xhr.onload = () => {
      const response = JSON.parse(xhr.responseText);
      packPlayers.innerHTML = "";
      packName.value = "";
      packPrice.value = "";
      playerVariantIDs = [];
    };

    const data = new FormData();

    data.append("name", packName.value);
    data.append("price", parseInt(packPrice.value));
    data.append("cards", playerVariantIDs);

    xhr.open("POST", "create_pack2_ajax.php", true);
    xhr.send(data);
  }
});
