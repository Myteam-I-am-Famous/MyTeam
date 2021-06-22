window.addEventListener("DOMContentLoaded", () => {
  const searchBar = document.getElementById("pack-searchbar");

  const packCreatorPlayers = document.getElementById("pack-creator-players");

  let players = [];

  searchBar.addEventListener("keyup", () => {
    if (searchBar.value.length >= 3) search(searchBar.value);
    if (searchBar.value.length == 0) {
      packCreatorPlayers.innerHTML = "";
      players = [];
    }
  });

  let response = null;

  function search(query) {
    const xhr = new XMLHttpRequest();

    xhr.onload = () => {
      response = JSON.parse(xhr.responseText);
      updatePackCreatorPlayers();
    };

    const data = new FormData();

    data.append("query", query);

    xhr.open("POST", "searchbar_ajax.php", true);
    xhr.send(data);
  }

  function updatePackCreatorPlayers() {
    if (response.response.length > 0) {
      response.response.forEach((player) => {
        if (!players.includes(player.id)) {
          players.push(player.id);

          const packCreatorPlayer = document.getElementById(player.full_name);
          if (packCreatorPlayer == undefined) {
            let newPackCreatorPlayer =
              '<div class="pack-creator-player" id="' + player.full_name + '">';
            newPackCreatorPlayer += "<h1>" + player.full_name + "</h1>";
            newPackCreatorPlayer +=
              '<div class="pack-creator-player-variant" id="' +
              player.id +
              '">';

            for (let i = 0; i < 10; i++) {
              newPackCreatorPlayer +=
                '<img src="http://content.mtdb.com/www/nba2k20/' +
                player.full_name.split(" ")[0].toLowerCase() +
                "-" +
                player.full_name.split(" ")[1].toLowerCase() +
                "-" +
                i +
                '.png" alt="">';
            }

            newPackCreatorPlayer += "</div>";
            newPackCreatorPlayer += "</div>";
            packCreatorPlayers.innerHTML += newPackCreatorPlayer;
          } else {
            let newPackCreatorPlayer = (newPackCreatorPlayer +=
              "<h1>" + player.full_name + "</h1>");
            newPackCreatorPlayer +=
              '<div class="pack-creator-player-variant" id="' +
              player.id +
              '">';

            for (let i = 0; i < 10; i++) {
              newPackCreatorPlayer +=
                '<img src="http://content.mtdb.com/www/nba2k20/' +
                player.full_name.split(" ")[0].toLowerCase() +
                "-" +
                player.full_name.split(" ")[1].toLowerCase() +
                "-" +
                i +
                '.png" alt="">';
            }

            newPackCreatorPlayer += "</div>";
            packCreatorPlayer.innerHTML += newPackCreatorPlayer;
          }
        }
      });
    }
  }

  window.addEventListener("keyup", (e) => {
    if (e.key === "Enter") {
      console.log(response);
    }
  });
});
