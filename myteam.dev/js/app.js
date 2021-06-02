const API = {
  baseURL: "https://site.web.api.espn.com/apis/common/v3/",
  nbaURL: "sports/basketball/nba/",
  nbaPlayer: "sports/basketball/nba/athletes/",
  stats: "/splits?season=2021",
  teams: "https://site.api.espn.com/apis/site/v2/sports/basketball/nba/teams/",
};

const statsIndexes = {
  GP: 0,
  MPG: 1,
  FGM: 2,
  FGP: 3,
  TPM: 4,
  TPP: 5,
  FTM: 6,
  FTP: 7,
  ORB: 8,
  DRB: 9,
  RPG: 10,
  APG: 11,
  BPG: 12,
  SPG: 13,
  FPG: 14,
  TPG: 15,
  PPG: 16,
};

const jersey_color = {
  ATL: "#E03A3E",
  BOS: "#007A33",
  BKN: "#000",
  CHA: "#1D1160",
  CHI: "#CE1141",
  CLE: "#6F263D",
  DAL: "#00538C",
  DEN: "#00285E",
  DET: "#ED174C",
  GSW: "#006BB6",
  HOU: "#CE1141",
  IND: "#002D62",
};

const jersey_bg = document.querySelector(".middle");

let cards = [
  "4066421",
  "1966",
  "4395628",
  "3975",
  "6442",
  "110",
  "3202",
  "3992",
];

const cardInventory = document.getElementById("card-inventory");

cards.forEach((card) => {
  const newCard = document.createElement("div");
  newCard.id = card;

  const newCardHeadshot = document.createElement("img");

  getPlayerByID(card).then((player) => {
    newCardHeadshot.classList.add("inventory-card");
    newCardHeadshot.addEventListener("click", (e) => {
      selectCard(card);
    });
    newCardHeadshot.src = player.athlete.headshot.href;

    newCard.appendChild(newCardHeadshot);

    cardInventory.appendChild(newCard);
  });
});

const input = document.getElementById("input");
const teamSelection = document.getElementById("team-selection");
const submit = document.getElementById("submit");
const buy = document.getElementById("buy");
const remove = document.getElementById("remove");

let currentPlayer = undefined;

const fullName = document.getElementById("name");
const number = document.getElementById("number");
const headshot = document.getElementById("headshot");
const position = document.getElementById("position");
const teamName = document.getElementById("team-name");
const teamLogo = document.getElementById("team-logo");
const ppg = document.getElementById("ppg");
const apg = document.getElementById("apg");
const mpg = document.getElementById("mpg");
const rpg = document.getElementById("rpg");
const fg = document.getElementById("fg");
const threePointer = document.getElementById("3pt");

const cardHandler = document.getElementById("card-handler");
const card = document.querySelector(".card");

input.addEventListener("keyup", (e) => {
  if (e.key === "Enter") {
    if (input.value.length > 0) {
      Search(input.value);
    }
  }
});

submit.addEventListener("click", () => {
  if (input.value.length > 0) {
    Search(input.value);
  }
});

remove.addEventListener("click", (e) => {
  if (currentPlayer !== undefined) {
    const cardElement = document.getElementById(currentPlayer);
    cardInventory.removeChild(cardElement);

    cards = cards.filter((card) => card !== currentPlayer);
  }
});

buy.addEventListener("click", (e) => {
  if (currentPlayer === undefined) return;

  if (cards.find((card) => card === currentPlayer) !== undefined) {
    alert("Vous possedez déja cette carte");
    return;
  } else {
    const card = currentPlayer;
    cards.push(card);

    const newCard = document.createElement("div");
    newCard.id = card;

    const newCardHeadshot = document.createElement("img");

    getPlayerByID(card).then((player) => {
      newCardHeadshot.classList.add("inventory-card");
      newCardHeadshot.addEventListener("click", (e) => {
        selectCard(card);
      });
      newCardHeadshot.src = player.athlete.headshot.href;

      newCard.appendChild(newCardHeadshot);

      cardInventory.appendChild(newCard);
    });
  }
});

async function Search(input) {
  const response = await fetch(API.teams + teamSelection.value + "/roster");
  const result = await response.json();

  const player = result.athletes.find(
    (athlete) =>
      athlete.firstName === input ||
      athlete.lastName === input ||
      athlete.fullName === input
  );

  if (player !== undefined) {
    currentPlayer = player.id;
    GetStatsByID(player.id).then((stats) => {
      updatePlayerCard(player, stats, result.team);
    });
  } else {
    alert("Joueur introuvable");
  }

  return result;
}

async function getTeamByABV(abv) {
  const response = await fetch(API.teams + abv + "/roster");
  const result = await response.json();

  return result;
}

async function GetStatsByID(id) {
  const response = await fetch(API.baseURL + API.nbaPlayer + id + API.stats);
  const result = await response.json();

  return result;
}

async function getPlayerByID(id) {
  const response = await fetch(API.baseURL + API.nbaPlayer + id);
  const result = await response.json();

  return result;
}

function selectCard(id) {
  getPlayerByID(id).then((player) => {
    GetStatsByID(id).then((stats) => {
      getTeamByABV(player.athlete.team.abbreviation).then((team) => {
        currentPlayer = id;
        updatePlayerCard(player.athlete, stats, team.team);
      });
    });
  });
}

function updatePlayerCard(player, stats, team) {
  //   jersey_bg.style.backgroundColor = getJerseyColor(team.abbreviation);
  fullName.textContent = player.fullName;

  number.textContent = player.jersey;
  teamLogo.src = team.logo;
  teamName.textContent = team.displayName;
  headshot.src = player.headshot.href;

  const statsValues = stats.splitCategories[0].splits[0].stats;

  mpg.textContent = statsValues[statsIndexes.MPG];
  ppg.textContent = statsValues[statsIndexes.PPG];
  apg.textContent = statsValues[statsIndexes.APG];
  rpg.textContent = statsValues[statsIndexes.RPG];
  fg.textContent = statsValues[statsIndexes.FGP];
  position.textContent = player.position.displayName;
  threePointer.textContent = statsValues[statsIndexes.TPP];
}

function getJerseyColor(abv) {
  const keys = Object.keys(jersey_color);
  const teamABV = keys.find((key) => key === abv.toUpperCase());
  if (teamABV !== undefined) {
    return jersey_color[teamABV];
  } else {
    return "#fff";
  }
}

cardHandler.addEventListener("mousemove", (e) => {
  let xAxis = (window.innerWidth / 2 - e.pageX) / 20;
  let yAxis = (window.innerHeight / 2 - e.pageY) / 20;

  card.style.transform = `rotateY(${-xAxis}deg) rotateX(${-yAxis}deg)`;
});

cardHandler.addEventListener("mouseenter", () => {
  card.style.transition = "none";
});

cardHandler.addEventListener("mouseleave", () => {
  card.style.transform = "rotate(0deg)";
  card.style.transition = "all 0.5s ease-in";
});
