let url = document.URL.split("/");
let channelId = url[4];

function fillGeneralInfoForm(name, slogan, banner) {
  document.getElementsByName("username")[0].value = name;
  document.getElementsByName("channel-desc")[0].value = slogan;
  document.getElementsByName("banner")[0].style.backgroundImage = "url('/assets/images/channels/"+banner+"')";
}

let fillGeneralRequest = new XMLHttpRequest();

fillGeneralRequest.onreadystatechange = function() {
  if (this.readyState === 4 && this.status === 200) {
    let response = JSON.parse(this.responseText);
    if(!response.success){
      return;
    }
    fillGeneralInfoForm(response.data.name, response.data.slogan, response.data.banner);
    channelId = response.data.name;
  }
}
fillGeneralRequest.open("GET", "/api/channel/" + channelId, true);
fillGeneralRequest.send();


let updateChannel = new XMLHttpRequest();

updateChannel.onreadystatechange = function() {
 
    if (this.readyState === 4 && this.status === 200) {
      let response = JSON.parse(this.responseText);
      if(!response.success){
        return;
      }
      fillGeneralInfoForm(response.data.name, response.data.slogan, response.data.banner);

  }
}

document.getElementById("submitChanges").onclick= function(){
  var channelName = document.querySelector("input[name='username']").value;
  var channelSlogan = document.querySelector("input[name='channel-desc']").value;

  var info={"name": channelName, "slogan": channelSlogan}
  let response = JSON.stringify(info);
  updateChannel.open("POST", "/api/channel/" + channelId+ "/"+ username+ "/update", true);
  updateChannel.setRequestHeader("csrf",csrf);
  updateChannel.setRequestHeader("Content-Type","application/json");
  updateChannel.send(response);
}