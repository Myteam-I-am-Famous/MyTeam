let result = "";

while (true) {
  const abv = prompt("Saisissez une abbréviation NBA : ");
  const team = prompt("Saisissez le nom de l'équipe : ");

  if (abv === "q") break;

  result += abv;

  if (team === "q") break;

  result += team;
}

console.log(result);
