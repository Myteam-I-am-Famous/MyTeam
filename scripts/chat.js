const messageInput = document.getElementById("message-input");
const chatContent = document.getElementById("chat-content");
const lastActivity = document.getElementById("last-activity");
const conversations = document.querySelectorAll(".conversation");
const treshold = 450;
let recipient = 2;

getMessages(true);
setInterval(() => {
  getMessages();
}, 3000);

lastActivity.innerHTML = getElapsedTime(new Date("2021-06-16 21:22").getTime());

messageInput.addEventListener("keyup", (e) => {
  if (e.key === "Enter") sendMessage(messageInput.value);
});

conversations.forEach((conversation) => {
  conversation.addEventListener("click", () => {
    recipient = conversation.id.split("-")[1];
    getMessages(true);
  });
});

function sendMessage(message) {
  if (message.length == 0) return false;
  const xhr = new XMLHttpRequest();
  const date = new Date();
  const time = Math.floor(date.getTime() / 1000);

  xhr.onload = () => {
    messageInput.value = "";
    getMessages();
  };

  const data = new FormData();

  data.append("message", message);
  data.append("time", time);
  data.append("recipient", recipient);

  xhr.open("POST", "chat_ajax.php", true);
  xhr.send(data);
}

function getMessages(firstTime = false) {
  const xhr = new XMLHttpRequest();

  xhr.onload = () => {
    const response = JSON.parse(xhr.responseText);
    console.log(response);
    refreshMessages(response.messages, response.uid);
    scrollDown(firstTime);
  };

  xhr.open("GET", "chat_ajax.php?request=read&recipient=" + recipient, true);
  xhr.send();
}

function refreshMessages(messages, uid) {
  const htmlMessages = messages
    .map((message) => {
      return `<div class="chat-message ${
        message.author == uid ? "my-message" : "other-message"
      }">
                <p class="message">${message.message}</p>
                <p class="message-time">${getElapsedTime(message.time)}</p>
              </div>`;
    })
    .join("");

  chatContent.innerHTML = htmlMessages;
}

function getElapsedTime(time) {
  const date = new Date();
  const secondsDiff = getTimeSeconds(date.getTime()) - time;
  let elapsedTime = "";
  if (secondsDiff < 60) {
    elapsedTime = "A l'instant";
  } else if (secondsDiff < 3600) {
    const minutes = Math.ceil(secondsDiff / 60);
    elapsedTime =
      "Il y'a environ " + minutes + " minute" + (minutes > 1 ? "s" : "");
  } else if (secondsDiff < 86400) {
    const hours = Math.ceil(secondsDiff / 3600);
    elapsedTime = "Il y'a environ " + hours + " heure" + (hours > 1 ? "s" : "");
  } else if (secondsDiff < 2678400) {
    const days = Math.floor(secondsDiff / 86400);
    elapsedTime = "Il y'a " + days + " jour" + (days > 1 ? "s" : "");
  } else if (secondsDiff < 32140800) {
    elapsedTime = "Il y'a " + Math.ceil(secondsDiff / 2678400) + " mois";
  } else {
    const years = Math.ceil(secondsDiff / 32140800);
    elapsedTime = "Il y'a " + years + " an" + (years > 1 ? "s" : "");
  }

  return elapsedTime;
}

function getTimeSeconds(time) {
  return Math.floor(time / 1000.0);
}

function scrollDown(firstTime = false) {
  if (firstTime) chatContent.scrollTop = chatContent.scrollHeight;
  else if (
    chatContent.scrollTop + chatContent.clientHeight >=
    chatContent.scrollHeight - treshold
  )
    chatContent.scrollTop = chatContent.scrollHeight;
}
