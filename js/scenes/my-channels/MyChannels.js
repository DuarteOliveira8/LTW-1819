import {getChannel} from '/js/shared-components/Channel.js';

let channels = document.getElementById('channels');

let showUserChannels = new XMLHttpRequest();

showUserChannels.onreadystatechange = function() {
  if (this.readyState === 4 && this.status === 200) {
    let response = JSON.parse(this.responseText);
    if (!response.success) {
      channels.innerHTML = `<h1>This user has no channels.</h1>`;
    }
    for(let i = 0; i < response.data.length; i++) {
      channels.append(getChannel(response.data[i].name,
                           response.data[i].posts,
                           response.data[i].subscriptions,
                           response.data[i].banner));
    }
  }
};

showUserChannels.open("GET", "/api/user/" + username + "/channels", true);
showUserChannels.send();