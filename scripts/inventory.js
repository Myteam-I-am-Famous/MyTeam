const cards = document.querySelectorAll(".myteam-card");
const overall = document.getElementById("overall");
const inventoryTableRows = document.querySelectorAll(".inventory-table-row");
const inventoryCardsContainer = document.querySelector(
  ".inventory-cards-container"
);
let targetCard = null;
let canSelectCard = false;

let cardOrder = [];
let slots = [
  {
    id: 4066421,
    overall: 87,
    team: "NO",
    position: "Point Guard",
    lastName: "BALL",
    conference: "WEST",
    slotNumber: 1,
  },
  {
    id: 1966,
    overall: 98,
    team: "LAL",
    lastName: "JAMES",
    conference: "WEST",
    slotNumber: 2,
  },
  {
    id: 4251,
    overall: 93,
    team: "LAC",
    position: "Point Guard",
    lastName: "GEORGE",
    conference: "WEST",
    slotNumber: 3,
  },
  {
    id: 3059318,
    overall: 93,
    team: "PHI",
    position: "Point Guard",
    lastName: "EMBIID",
    conference: "WEST",
    slotNumber: 4,
  },
  {
    id: 4277905,
    overall: 91,
    team: "ATL",
    position: "Point Guard",
    lastName: "YOUNG",
    conference: "WEST",
    slotNumber: 5,
  },
];
let players = [];

updateTeamOverall();
initializeInventory();

const baseImageURL = "http://content.mtdb.com/www/nba2k20/"; // firstname-lastname.png

cards.forEach((card) => {
  cardOrder.push(card.id.split("-")[1]);

  card.addEventListener("dragstart", (e) => {
    e.dataTransfer.setData("text/plain", card.id);
  });

  card.addEventListener("click", () => {
    if (card.classList.contains("myteam-card-active")) {
      cards.forEach((card) => {
        card.classList.remove("myteam-card-active");
      });
      targetCard = null;
      canSelectCard = false;
    } else {
      cards.forEach((card) => {
        card.classList.remove("myteam-card-active");
      });
      card.classList.add("myteam-card-active");
      targetCard = card;
      canSelectCard = true;
    }
  });

  card.addEventListener("dragover", (e) => {
    e.preventDefault();
  });

  card.addEventListener("drop", (e) => {
    const firstCard = document.getElementById(e.dataTransfer.getData("text"));

    if (firstCard !== undefined) swapCards(firstCard, e.currentTarget);

    e.dataTransfer.clearData();
  });
});

inventoryTableRows.forEach((row) => {
  row.addEventListener("click", () => {
    const name = (
      row.children[1].textContent.split(" ")[0] +
      "-" +
      row.children[1].textContent.split(" ")[1]
    ).toLowerCase();

    if (targetCard !== null && canSelectCard) {
      const imageURL =
        baseImageURL + name + "-" + parseInt(Math.random() * 5 + 1) + ".png";

      const slot = slots[targetCard.id.split("-")[1] - 1];
      slot.lastName = name.split("-")[1].toUpperCase();
      slot.overall = parseInt(row.children[7].textContent);
      slot.id = row.children[0].textContent;
      slot.team = row.children[5].textContent;
      slot.position = row.children[4].textContent;

      checkImage(
        imageURL,
        () => {
          targetCard.children[0].src = imageURL;
        },
        () => {
          targetCard.children[0].src = baseImageURL + name + "-1.png";
        }
      );
    }
  });
});

function swapCards(firstCard, secondCard) {
  if (firstCard.id == secondCard.id) return false;

  if (
    firstCard.children[0].src != undefined &&
    secondCard.children[0].src != undefined
  ) {
    const tempSrc = firstCard.children[0].src;
    firstCard.children[0].src = secondCard.children[0].src;
    secondCard.children[0].src = tempSrc;
  } else if (firstCard.children[0].src != undefined) {
    secondCard.innerHTML = firstCard.innerHTML;
    firstCard.innerHTML = "<h1>Empty</h1>";
  } else if (secondCard.children[0].src != undefined) {
    firstCard.innerHTML = secondCard.innerHTML;
    secondCard.innerHTML = "<h1>Empty</h1>";
  }

  const tempCard = firstCard.id;
  firstCard.id = secondCard.id;
  secondCard.id = tempCard;

  cardOrder = [];
  cards.forEach((card) => {
    cardOrder.push(card.id.split("-")[1]);
  });

  updateTeamOverall();

  return true;
}

function updateTeamOverall() {
  let teamOverall = 0;
  slots.forEach((slot) => {
    teamOverall += slot.overall;
  });

  const xhr = new XMLHttpRequest();

  xhr.onload = () => {
    overall.textContent = "Team Overall : " + parseInt(teamOverall / 5);
  };

  const data = new FormData();

  data.append("team_overall", parseInt(teamOverall / 5));

  xhr.open("POST", "inventory_ajax.php", true);
  xhr.send(data);
}

function initializeInventory() {
  const xhr = new XMLHttpRequest();

  xhr.onload = () => {
    const response = JSON.parse(xhr.responseText);
    organizeInventory(response.data);
  };

  const data = new FormData();

  data.append("initialize", true);

  xhr.open("POST", "inventory_ajax.php", true);
  xhr.send(data);
}

function checkImage(imageSrc, good, bad) {
  var img = new Image();
  img.onload = good;
  img.onerror = bad;
  img.src = imageSrc;
}

function organizeInventory(cards) {
	if(cards.length == 0){
		let emptyInventory = '<div class="empty-inventory"><h1>Inventaire vide 😥</h1>';
		emptyInventory += '<p>Achetez des cartes au shop <a href="myteam-shop"><span class="blue">MY</span><span class="red">TEAM</span> SHOP</a>';
		inventoryCardsContainer.innerHTML += emptyInventory;
	}
  cards.forEach((card) => {
    if (players.includes(card.id)) {
      let newCard = `<div class="inventory-card" id="card-${card.id}-${card.variant}">`;
      newCard += `<img src="${card.variantURL}" alt="" srcset="">`;
      newCard += "</div>";
      document.getElementById(card.id + "-row").innerHTML += newCard;
    } else {
      players.push(card.id);
      let newInventoryCards = `<div class="inventory-cards" id="${card.id}-row">`;
      newInventoryCards += '<div class="inventory-card-name">';
      newInventoryCards += `<h3>${card.full_name}</h3>`;
      newInventoryCards += "</div>";
      newInventoryCards += `<div class="inventory-card" id="card-${card.id}-${card.variant}">`;
      newInventoryCards += `<img src="${card.variantURL}" alt="" srcset="">`;
      newInventoryCards += "</div>";
      newInventoryCards += "</div>";

      inventoryCardsContainer.innerHTML += newInventoryCards;
    }
  });
}
