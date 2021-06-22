const time = document.getElementById("time");

const date = new Date();
const date2 = new Date("2021-06-16 21:44:25");
time.innerHTML = Math.floor(date.getTime() / 1000);
time.innerHTML += "<br>";
time.innerHTML += date.getHours() + ":" + date.getMinutes();

const elapsedTime = getElapsedTime(date2.getTime());

console.log(elapsedTime);

function getTimeSeconds(time) {
  return Math.floor(time / 1000.0);
}

function getElapsedTime(time) {
  const date = new Date();
  const secondsDiff = getTimeSeconds(date.getTime() - time);
  console.log(secondsDiff);
  let result = "Long time ago";
  if (secondsDiff < 60) {
    result = "A l'instant";
  } else if (secondsDiff < 86400) {
    const hours = Math.ceil(secondsDiff / 3600);
    result = "Il y'a environ " + hours + " heure" + (hours > 1 ? "s" : "");
  } else if (secondsDiff < 2678400) {
    const days = Math.floor(secondsDiff / 86400);
    result = "Il y'a " + days + " jour" + (days > 1 ? "s" : "");
  } else if (secondsDiff < 32140800) {
    result = "Il y'a " + Math.ceil(secondsDiff / 2678400) + " mois";
  } else {
    const years = Math.ceil(secondsDiff / 32140800);
    result = "Il y'a " + years + " an" + (years > 1 ? "s" : "");
  }

  return result;
}
