function addComment(id) {
    const commentTextarea = document.querySelector(".comment-section textarea");
    const comment = commentTextarea.value.trim();
  
    if (comment !== "") {
      const request = new XMLHttpRequest();
      request.open("POST", "../actions/action_addComment.php", true);
      request.setRequestHeader(
        "Content-Type",
        "application/x-www-form-urlencoded"
      );
  
      const data = "id=" + id + "&comment=" + encodeURIComponent(comment);
      console.log(id);
      request.onload = function () {
        if (request.status >= 200 && request.status < 400) {
          console.log(request.responseText);
  
          window.location.reload();
        } else {
          console.error("Error adding comment:", request.statusText);
        }
      };
      request.onerror = function () {
        console.error("Error");
      };
      request.send(data);
    } else {
      alert("Add comment before sending it!");
    }
  }