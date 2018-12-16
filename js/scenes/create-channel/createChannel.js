let createChannel = new XMLHttpRequest();

createChannel.onreadystatechange = function() {

    if (this.readyState === 4 && this.status === 200) {
      let response = JSON.parse(this.responseText);
      if(!response.success){
        return;
      }
      window.location.href = "/";
  }
}

document.getElementById("submitButton").onclick= function(){
  var name = document.querySelector("input[name='channel-name']").value;
  var slogan = document.querySelector("input[name='channel-slogan']").value;
  var infoChannel={"name": name, "slogan": slogan}
  let response = JSON.stringify(infoChannel);
  createChannel.open("POST", "/api/user/" + username + "/create-channel", true);
  createChannel.setRequestHeader("csrf",csrf);
  createChannel.send(response);
}