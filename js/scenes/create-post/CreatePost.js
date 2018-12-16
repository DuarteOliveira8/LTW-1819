let url = document.URL.split("/");
let channel = url[4];

let createPost = new XMLHttpRequest();

createPost.onreadystatechange = function() {
  if (this.readyState === 4 && this.status === 200) {
    let response = JSON.parse(this.responseText);
    if (!response.success) {
      console.log(response.error);
      return; //TODO: handle later
    }
    window.location.href = "/";
  }
};

document.getElementById("submitButton").onclick= function(){
  var name = document.querySelector("input[name='post-title']").value;
  var desc = document.querySelector("textarea[name='post-description']").value;
  let date = new Date().toJSON().slice(0,10).replace(/-/g,'-');
  console.log(date);
  var infoPost={"title": name, "description": desc, "date": date, "channel": channel};
  let response = JSON.stringify(infoPost);
  createPost.open("POST", "/api/channel/" + channel + "/" + username + "/create-post", true);
  createPost.setRequestHeader("csrf",csrf);
  createPost.send(response);
}
