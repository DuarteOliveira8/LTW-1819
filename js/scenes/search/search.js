import {getChannel} from '/js/shared-components/Channel.js';

let channels = document.getElementById('channels');

// let foundChannels = new XMLHttpRequest();

// foundChannels.onreadystatechange = function() {
//   if (this.readyState === 4 && this.status === 200) {
//     let response = JSON.parse(this.responseText);
//     if (!response.success) {
//       channels.innerHTML = `<h1>There is no such channel with that name.</h1>`;
//     }
    for(let i = 0; i < 10; i++) {
      channels.append(getChannel("asd",
                           "10",
                           "3",
                           "1.jpg"));
    }

// foundChannels.open("GET", "/api/user/" + username + "/channels", true);
// foundChannels.send();