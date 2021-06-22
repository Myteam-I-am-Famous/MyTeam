window.addEventListener("DOMContentLoaded", () => {
  const searchBar = document.getElementById("searchbar");
  const autoComplete = document.getElementById("auto-complete");

  searchBar.addEventListener("keyup", () => {
    if (searchBar.value.length > 0) search(searchBar.value);
    else autoComplete.textContent = "";
  });

  let response = null;

  function search(query) {
    const xhr = new XMLHttpRequest();

    xhr.onload = () => {
      response = JSON.parse(xhr.responseText);
      // console.log(xhr.responseText);
      updateUserAutoComplete(response.users);
      updateForumsAutoComplete(response.forums);
      updateArticlesAutoComplete(response.articles);
      updateAthletesAutoComplete(response.athletes);
    };

    const data = new FormData();

    data.append("query", query);

    xhr.open("POST", "searchbar_ajax.php", true);
    xhr.send(data);
  }

  function updateUserAutoComplete(queries) {
    autoComplete.innerHTML = "";

    if (queries.length > 0) {
      autoComplete.innerHTML += "<h3 class='auto-complete-section'>Users</h3>";

      queries.forEach((query) => {
        let newAutoCompleteResponse =
          '<div class="auto-complete-response user-response">';
        newAutoCompleteResponse +=
          "<p>" +
          query.first_name +
          " " +
          query.last_name +
          " (" +
          query.pseudo +
          ")</p>";
        newAutoCompleteResponse += "</div>";

        autoComplete.innerHTML += newAutoCompleteResponse;
      });
      const autoCompleteResponses = document.querySelectorAll(
        ".auto-complete-response"
      );
      autoCompleteResponses.forEach((autoCompleteResponse) => {
        autoCompleteResponse.addEventListener("click", () => {
          autoComplete.innerHTML = "";
          searchBar.value = autoCompleteResponse.textContent;
        });
      });
    }
  }
  function updateAthletesAutoComplete(queries) {
    if (queries.length > 0) {
      autoComplete.innerHTML +=
        "<h3 class='auto-complete-section'>Athletes</h3>";

      queries.forEach((query) => {
        let newAutoCompleteResponse =
          '<div class="auto-complete-response athlete-response">';
        newAutoCompleteResponse +=
          "<p>" + query.full_name + " " + query.team_abv + "</p>";
        newAutoCompleteResponse += "</div>";

        autoComplete.innerHTML += newAutoCompleteResponse;
      });
      const autoCompleteResponses = document.querySelectorAll(
        ".auto-complete-response"
      );
      autoCompleteResponses.forEach((autoCompleteResponse) => {
        autoCompleteResponse.addEventListener("click", () => {
          autoComplete.innerHTML = "";
          searchBar.value = autoCompleteResponse.textContent;
        });
      });
    }
  }
  function updateForumsAutoComplete(queries) {
    if (queries.length > 0) {
      autoComplete.innerHTML += "<h3 class='auto-complete-section'>Forums</h3>";
      console.log(queries);
      queries.forEach((query) => {
        let newAutoCompleteResponse =
          '<a href="forum-' +
          query.id +
          '"><div class="auto-complete-response forum-response">';
        newAutoCompleteResponse += "<p>" + query.title + "</p>";
        newAutoCompleteResponse += "</div></a>";

        autoComplete.innerHTML += newAutoCompleteResponse;
      });
      const autoCompleteResponses = document.querySelectorAll(
        ".auto-complete-response"
      );
      autoCompleteResponses.forEach((autoCompleteResponse) => {
        autoCompleteResponse.addEventListener("click", () => {
          autoComplete.innerHTML = "";
          searchBar.value = autoCompleteResponse.textContent;
        });
      });
    }
  }
  function updateArticlesAutoComplete(queries) {
    if (queries.length > 0) {
      autoComplete.innerHTML +=
        "<h3 class='auto-complete-section'>Articles</h3>";
      queries.forEach((query) => {
        let newAutoCompleteResponse =
          '<a href="article/' +
          query.id +
          '"><div class="auto-complete-response article-response">';
        newAutoCompleteResponse += "<p>" + query.title + "</p>";
        newAutoCompleteResponse += "</div></a>";

        autoComplete.innerHTML += newAutoCompleteResponse;
      });
      const autoCompleteResponses = document.querySelectorAll(
        ".auto-complete-response"
      );
      autoCompleteResponses.forEach((autoCompleteResponse) => {
        autoCompleteResponse.addEventListener("click", () => {
          autoComplete.innerHTML = "";
          searchBar.value = autoCompleteResponse.textContent;
        });
      });
    }
  }

  window.addEventListener("keyup", (e) => {
    if (e.key === "Enter") {
      console.log(response);
    }
  });
});

