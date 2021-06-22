const bookmark = document.getElementById("bookmark");
const forumID = document.getElementById("id");

const likeBtn = document.querySelector(".likes");
const likesValue = document.getElementById("likes-value");
const dislikeBtn = document.querySelector(".dislikes");
const dislikesValue = document.getElementById("dislikes-value");

bookmark.addEventListener("click", () => {
  if (bookmark.classList.contains("far")) {
    bookmark.className = "fas fa-bookmark";
    toggleBookmark(true);
  } else if (bookmark.classList.contains("fas")) {
    bookmark.className = "far fa-bookmark";
    toggleBookmark(false);
  }
});

likeBtn.addEventListener("click", () => {
  likeForumSubject();
});

dislikeBtn.addEventListener("click", () => {
  likeForumSubject(false);
});

function toggleBookmark(status) {
  const xhr = new XMLHttpRequest();

  xhr.onload = () => {
    // const response = JSON.parse(xhr.responseText);
    // console.log(response);
    console.log(xhr.responseText);
  };

  let request = "?request=bookmark";
  request += "&status=" + status;
  request += "&type=subject";
  request += "&forum=" + forumID.textContent;

  xhr.open("GET", "forum_subject_ajax.php" + request, true);
  xhr.send();
}

function likeForumSubject(status = true) {
  const xhr = new XMLHttpRequest();

  xhr.onload = () => {
    const response = JSON.parse(xhr.responseText);
    console.log(response);
    if (status) {
      if (response.value) {
        likeBtn.classList.add("active");
        likeBtn.style.color = "#0fbb3a";
        dislikeBtn.style.color = "#0000006e";
        likesValue.textContent = parseInt(likesValue.textContent) + 1;
        if (dislikeBtn.classList.contains("active")) {
          dislikesValue.textContent = parseInt(dislikesValue.textContent) + 1;
          dislikeBtn.classList.remove("active");
        }
      } else {
        likeBtn.classList.remove("active");
        likeBtn.style.color = "#0000006e";
        likesValue.textContent = parseInt(likesValue.textContent) - 1;
      }
    } else {
      if (response.value == -1) {
        dislikeBtn.classList.add("active");
        dislikeBtn.style.color = "#f22";
        likeBtn.style.color = "#0000006e";
        dislikesValue.textContent = parseInt(dislikesValue.textContent) - 1;
        if (likeBtn.classList.contains("active")) {
          likesValue.textContent = parseInt(likesValue.textContent) - 1;
          likeBtn.classList.remove("active");
        }
      } else {
        dislikeBtn.classList.remove("active");
        dislikeBtn.style.color = "#0000006e";
        dislikesValue.textContent = parseInt(dislikesValue.textContent) + 1;
      }
    }
  };

  let request = "?request=" + (status ? "like" : "dislike");
  request += "&type=subject";
  request += "&forum=" + forumID.textContent;

  xhr.open("GET", "forum_subject_ajax.php" + request, true);
  xhr.send();
}

function likeForumReaction(status = true) {
  const xhr = new XMLHttpRequest();

  xhr.onload = () => {
    const response = JSON.parse(xhr.responseText);
    console.log(response);
    if (status) {
      if (response.value) {
        likeBtn.classList.add("active");
        likeBtn.style.color = "#0fbb3a";
        dislikeBtn.style.color = "#0000006e";
        likesValue.textContent = parseInt(likesValue.textContent) + 1;
        if (dislikeBtn.classList.contains("active")) {
          dislikesValue.textContent = parseInt(dislikesValue.textContent) + 1;
          dislikeBtn.classList.remove("active");
        }
      } else {
        likeBtn.classList.remove("active");
        likeBtn.style.color = "#0000006e";
        likesValue.textContent = parseInt(likesValue.textContent) - 1;
      }
    } else {
      if (response.value == -1) {
        dislikeBtn.classList.add("active");
        dislikeBtn.style.color = "#f22";
        likeBtn.style.color = "#0000006e";
        dislikesValue.textContent = parseInt(dislikesValue.textContent) - 1;
        if (likeBtn.classList.contains("active")) {
          likesValue.textContent = parseInt(likesValue.textContent) - 1;
          likeBtn.classList.remove("active");
        }
      } else {
        dislikeBtn.classList.remove("active");
        dislikeBtn.style.color = "#0000006e";
        dislikesValue.textContent = parseInt(dislikesValue.textContent) + 1;
      }
    }
  };

  let request = "?request=" + (status ? "like" : "dislike");
  request += "&type=reaction";
  request += "&forum=" + forumID.textContent;
  request += "&reaction=3";

  xhr.open("GET", "forum_subject_ajax.php" + request, true);
  xhr.send();
}
