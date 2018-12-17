let comments = document.getElementById('comments');

let showComments = new XMLHttpRequest();

showComments.onreadystatechange = function() {
  if (this.readyState === 4 && this.status === 200) {
    let response = JSON.parse(this.responseText);
    if (!response.success) {
      comments.innerHTML = `<h1>There are no comments.</h1>`;
    }
    for(let i = 0; i < response.data.length; i++) {
      //posts.append(getComment());
    }
    requesting = false;
  }
};

showComments.open("POST", "/api/channel/" + channelId + "/posts", true);
let reqObj = {"offset":postOffset};
let request = JSON.stringify(reqObj);
showComments.send(request);

document.addEventListener('scroll', function (event) {
    if ((document.body.scrollHeight == Math.ceil(document.body.scrollTop + window.innerHeight)) && !requesting) {
      requesting = true;
      postOffset += 8;
      reqObj = {"offset": postOffset};
      request = JSON.stringify(reqObj);
      showComments.open("POST", "/api/channel/" + channelId + "/posts", true);
      showComments.setRequestHeader("Content-Type", "application/json");
      showComments.send(request);
    }
});
