const searchInput = document.getElementById("search-card");
const selectSport = document.getElementById("search-sport");
const searchSubmit = document.getElementById("search-submit");

const ppg = document.getElementById("ppg");
const packHeadshot = document.getElementById("pack-headshot");
const packTeam = document.getElementById("pack-team");

const nbaAPI = {
  baseURL:
    "https://site.web.api.espn.com/apis/common/v3/sports/basketball/nba/",
  athletes: "athletes/",
  teams: "teams/",
  stats: "splits?season=2021",
};

searchInput.addEventListener("keyup", (e) => {
  if (e.key === "Enter") Search();
});

searchSubmit.addEventListener("click", () => {
  Search();
});

function Search() {
  if (searchInput.value.length === 0 || isNaN(searchInput.value)) return false;

  getAthlete(searchInput.value).then((athlete) => {
    getAthleteStats(searchInput.value).then((stats) => {
      getPlayerCard(
        searchInput.value,
        athlete,
        stats.splitCategories[0].splits[0].stats,
        athlete.team
      );
    });
  });
}

async function getAthlete(id) {
  const request = await fetch(nbaAPI.baseURL + nbaAPI.athletes + id);

  if (request.ok) {
    const result = await request.json();
    return result.athlete;
  }
  return false;
}

async function getAthleteStats(id) {
  const request = await fetch(
    nbaAPI.baseURL + nbaAPI.athletes + id + "/" + nbaAPI.stats
  );

  if (request.ok) {
    const result = await request.json();
    return result;
  }
  return false;
}

function getPlayerCard(id, athlete, stats, team) {
  const xhr = new XMLHttpRequest();

  xhr.onload = () => {
    const response = JSON.parse(xhr.responseText);
    if (!response.result) {
      const status = (document.getElementById("status").textContent = "Erreur");
    } else {
      const status = (document.getElementById("status").textContent =
        "Success");
    }
  };

  const data = new FormData();
  data.append("id", id);
  data.append("fullname", athlete.fullName);
  data.append("jersey", athlete.jersey);
  data.append("headshot", athlete.headshot.href);
  data.append("position", athlete.position.displayName);
  data.append("team", team.displayName);
  data.append("teamABV", team.abbreviation);
  data.append("gp", stats[0]);
  data.append("min", stats[1]);
  data.append("fg", stats[3]);
  data.append("tp", stats[5]);
  data.append("ft", stats[7]);
  data.append("reb", stats[10]);
  data.append("ast", stats[11]);
  data.append("blk", stats[12]);
  data.append("stl", stats[13]);
  data.append("ppg", stats[16]);

  xhr.open("POST", "pack_card_check.php", true);
  // xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send(data);
}
