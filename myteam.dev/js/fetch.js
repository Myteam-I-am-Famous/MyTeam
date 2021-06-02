const input = document.getElementById("input");
const teamSelection = document.getElementById("team-selection");
const submit = document.getElementById("submit");

const fullName = document.getElementById("name");
const number = document.getElementById("number");
const headshot = document.getElementById("headshot");
const teamLogo = document.getElementById("team-logo");
const teamName = document.getElementById("team-name");
const ppg = document.getElementById("ppg");
const apg = document.getElementById("apg");
const rpg = document.getElementById("rpg");
const fg = document.getElementById("fg");
const threePointer = document.getElementById("3pt");
const stl = document.getElementById("stl");
const blk = document.getElementById("blk");
const min = document.getElementById("min");

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

const API = {
  baseURL: "https://site.web.api.espn.com/apis/common/v3/",
  nbaURL: "sports/basketball/nba/",
  nbaPlayer: "sports/basketball/nba/athletes/",
  stats: "/splits?season=2021",
  teams: "https://site.api.espn.com/apis/site/v2/sports/basketball/nba/teams/",
};

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

async function Search(input) {
  const response = await fetch(API.teams + "no/roster");
  const result = await response.json();

  const athletes = result.athletes;

  const player = athletes.find(
    (athlete) => athlete.firstName === input || athlete.lastName === input
  );

  if (player !== undefined) {
    GetStats(player.id).then((stats) => {
      console.log(stats);

      const statsName = stats.displayNames;
      initPlayerStats(stats);
    });

    fullName.textContent = player.fullName;
    number.textContent = player.jersey;
    // teamLogo.src = player.teams[0].
    headshot.src = player.headshot.href;
  }

  return result;
}

async function GetStats(id) {
  const response = await fetch(API.baseURL + API.nbaPlayer + id + API.stats);
  const result = await response.json();

  return result;
}

function initPlayerStats(stats) {
  const statsValues = stats.splitCategories[0].splits[0].stats;

  min.textContent = statsValues[statsIndexes.MPG];
  ppg.textContent = statsValues[statsIndexes.PPG];
  apg.textContent = statsValues[statsIndexes.APG];
  rpg.textContent = statsValues[statsIndexes.RPG];
  fg.textContent = statsValues[statsIndexes.FGP];
  threePointer.textContent = statsValues[statsIndexes.TPP];
  stl.textContent = statsValues[statsIndexes.SPG];
  blk.textContent = statsValues[statsIndexes.BPG];
}
