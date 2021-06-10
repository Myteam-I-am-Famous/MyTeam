window.addEventListener(`DOMContentLoaded`, () => {
  const events = document.getElementById(`events`);

  const soccerAPI = {
    baseURL: `http://site.api.espn.com/apis/site/v2/sports/soccer/`,
    ligue1: `fra.1/`,
    scoreboard: `scoreboard`,
  };

  Search();

  async function Search() {
    // if (searchBar.value.length == 0) return false;

    const response = await fetch(
      soccerAPI.baseURL + soccerAPI.ligue1 + soccerAPI.scoreboard
    );
    const result = response.ok ? await response.json() : false;

    const soccerEvents = result.events;

    /// result.events.id

    /// results['events'] => result.events en JSON

    // events -> events[i] , events[i +1....]

    soccerEvents.forEach((event) => addEvent(event));

    return result;
  }

  function addEvent(event) {
    let newEvent = '<div class="event">';

    /*
      <?php echo '<img src="test.png" />' ?>
    */

    newEvent += '<div class="time">';

    const date = new Date(event.date);

    // J M A H S M...

    const options = {
      weekday: "long",
      year: "numeric",
      month: "long",
      day: "numeric",
    };

    const localDate = date.toLocaleDateString("fr-FR", options);

    //Dimanche 23 MAI

    //LUNDI => LUN

    // Mohammed-Fadel-Abdoulaye-Gavin
    // split('-')[1]

    // Dimanche 15 JUIN

    //Dimanche => Dim

    const slicedDate = localDate.replace(
      localDate.split(" ")[0],
      // Dimanche
      localDate.split(" ")[0].slice(0, 3)
    );

    newEvent += `<h3>${slicedDate.toUpperCase()}</h3>`;

    // 17:3
    // 17:03
    // 17:+'0' + minutes..
    // 17:13 => 17:013

    const time = date.getHours() + ":" + ("0" + date.getMinutes()).slice(-2);

    newEvent += `<p>${time}</p>`;
    newEvent += "</div>";
    newEvent += '<div class="details">';
    event.competitions[0].details.forEach((detail) => {
      newEvent += '<div class="detail">';
      newEvent += `<p>${detail.clock.displayValue}</p>`;
      // newEvent += `<p>${event.competitions[0].details[0].type.text}</p>`;
      newEvent += `<p>${detail.athletesInvolved[0].fullName}</p>`;
      newEvent += `${
        '<img src="./assets/images/' +
        detail.type.text.split(" ")[0].toLowerCase() +
        '.svg" alt="" style="height:30px">'
      }`;
      newEvent += "</div>";
    });
    newEvent += "</div>";
    newEvent += '<div class="team">';
    newEvent += `<h3>${event.competitions[0].competitors[1].team.shortDisplayName}</h3>`;
    newEvent += `<img src="https://a.espncdn.com/i/teamlogos/soccer/500/${event.competitions[0].competitors[1].team.id}.png" alt="">`;
    newEvent += "</div>";
    newEvent += '<div class="score">';
    newEvent += `<span>${event.competitions[0].competitors[1].score}</span>`;
    newEvent += "<span>-</span>";
    newEvent += `<span>${event.competitions[0].competitors[0].score}</span>`;
    newEvent += "</div>";
    newEvent += '<div class="team">';
    newEvent += `<img src="https://a.espncdn.com/i/teamlogos/soccer/500/${event.competitions[0].competitors[0].team.id}.png" alt="">`;
    newEvent += `<h3>${event.competitions[0].competitors[0].team.displayName}</h3>`;
    newEvent += "</div>";
    newEvent += '<div class="clock">';
    newEvent += `<h3>${event.status.displayClock}</h3>`;
    newEvent += `<span>${event.status.period}</span>`;
    newEvent += "</div>";
    newEvent += "</div>";

    events.innerHTML += newEvent;
  }
  // Search();
});
