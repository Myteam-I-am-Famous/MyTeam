const buy = document.getElementById("buy");
const refresh = document.getElementById("refresh");
const cardImg = document.querySelector("#card-1 img");

Array.prototype.random = function () {
  return this[Math.floor(Math.random() * this.length)];
};

const teamABV = [
  "ATL",
  "BOS",
  "CHA",
  "CHI",
  "CLE",
  "DAL",
  "DEN",
  "DET",
  "GSW",
  "HOU",
  "IND",
  "LAC",
  "LAL",
  "MEM",
  "MIA",
  "MIL",
  "MIN",
  "NO",
  "NYK",
  "ORL",
  "PHI",
  "PHX",
  "POR",
  "SA",
  "SAC",
  "TOR",
  "UTH",
  "WSH",
];

const baseURL =
  "https://site.api.espn.com/apis/site/v2/sports/basketball/nba/teams/";

const randomTeams = [0, 1, 2, 3, 4];
let randomTeam;
let randomAthlete;

refresh.addEventListener("click", () => {
  randomTeam = teamABV.random();
  Search();
});

function getRandomInt(min, max) {
  min = Math.ceil(min);
  max = Math.floor(max);
  return Math.floor(Math.random() * (max - min + 1)) + min;
}

async function Search() {
  const response = await fetch(
    nbaAPI.baseURL + nbaAPI.teams + randomTeam + "/roster"
  );
  const result = response.ok ? await response.json() : false;

  getRandomAthlete(result.positionGroups[0].athletes);
}

function getRandomAthlete(athletes) {
  const randomAthlete = athletes.random();

  const athleteName = (
    randomAthlete.fullName.split(" ")[0] +
    "-" +
    randomAthlete.fullName.split(" ")[1]
  ).toLowerCase();

  const imageURL = `http://content.mtdb.com/www/nba2k20/${athleteName}-1.png`;

  checkImage(
    imageURL,
    () => {
      cardImg.src = imageURL;
      getAthleteStats(randomAthlete.id).then((stats) => {
        const athleteTeam = randomAthlete.teams[randomAthlete.teams.length - 1];

        getPlayerCard(
          randomAthlete.id,
          randomAthlete,
          stats.splitCategories[0].splits[0].stats,
          athleteTeam
        );
      });
    },
    () => {
      getRandomAthlete(athletes);
    }
  );
}

function checkImage(imageSrc, good, bad) {
  const img = new Image();
  img.onload = good;
  img.onerror = bad;
  img.src = imageSrc;
}

// async function getAthleteStats(id) {
//   const request = await fetch(
//     nbaAPI.baseURL + nbaAPI.athletes + id + "/" + nbaAPI.stats
//   );
// }
