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
      updateAutoComplete(response.response);
    };

    const data = new FormData();

    data.append("query", query);

    xhr.open("POST", "searchbar_ajax.php", true);
    xhr.send(data);
  }

  function updateAutoComplete(queries) {
    autoComplete.innerHTML = "";

    if (queries.length > 0) {
      queries.forEach((query) => {
        let newAutoCompleteResponse = '<div class="auto-complete-response">';
        newAutoCompleteResponse += "<p>" + query.full_name + "</p>";
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

  window.addEventListener("keyup", (e) => {
    if (e.key === "Enter") {
      console.log(response);
    }
  });
});
