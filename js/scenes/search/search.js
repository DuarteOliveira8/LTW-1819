import {getChannel} from '/js/shared-components/Channel.js';

let url = document.URL.split("/");

let search = url[4];
let channels = document.getElementById('channels');

 let foundChannels = new XMLHttpRequest();

 foundChannels.onreadystatechange = function() {
   if (this.readyState === 4 && this.status === 200) {
     let response = JSON.parse(this.responseText);
     if (!response.success || response.data.length==0) {
       channels.innerHTML = `<h1>There is no such channel with that name.</h1>`;
     }
     console.log(response)
    for(let i = 0; i < response.data.length; i++) {
      channels.append(getChannel(response.data[i].name,
                           response.data[i].posts,
                           response.data[i].subscriptions,
                           response.data[i].banner));
    }
  }   
};

foundChannels.open("GET", "/api/search/" + search, true);
foundChannels.send();