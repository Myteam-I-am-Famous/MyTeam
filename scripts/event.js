//? Countdown pour les événements.
const days = document.getElementById("days");
const hours = document.getElementById("hours");
const minutes = document.getElementById("minutes");
const seconds = document.getElementById("seconds");
const countDown = document.getElementById("countdown");

setInterval(function () {
  seconds.textContent = ("0" + parseInt(seconds.textContent - 1)).slice(-2);
  if (seconds.textContent == "00") {
    seconds.textContent = "59";
    minutes.textContent = ("0" + parseInt(minutes.textContent - 1)).slice(-2);
    if (minutes.textContent == "00") {
      minutes.textContent = "59";
      hours.textContent = ("0" + parseInt(minutes.textContent - 1)).slice(-2);
      if (hours.textContent == "00") {
        hours.textContent = "23";
        days.textContent = parseInt(minutes.textContent - 1);
        if (parseInt(days.textContent) <= 0) {
          countDown.innerHTML = "L'événement à commencer !!!";
        }
      }
    }
  }
}, 1000);

//? CALL AJAX pour l'interaction avec la page d'événements.

const join = document.getElementById("join");
const eventID = document.getElementById("event-id");

join.addEventListener("click", () => {
  interactWithEvent();
});

function interactWithEvent() {
  const xhr = new XMLHttpRequest();

  xhr.onload = () => {
    const response = JSON.parse(xhr.responseText);
    console.log(response);
    if ((response.status = true)) {
      switch (response.operation) {
        case "join":
          join.classList.add("joined");
          join.textContent = "Quitter l'événement";
          break;
        case "quit":
          join.classList.remove("joined");
          join.textContent = "Rejoindre l'événement";
          break;
      }
    }
  };

  const data = new FormData();

  data.append("event_id", eventID.textContent);

  xhr.open("POST", "event_ajax.php", true);
  xhr.send(data);
}

//? Un peu d'animation

const participants = document.getElementById("participants");
const participantList = document.getElementById("participant-list");

participants.addEventListener("mouseover", () => {
  participantList.style.transform = "translateY(0%)";
});

participantList.addEventListener("mouseleave", () => {
  participantList.style.transform = "translateY(100%)";
});
