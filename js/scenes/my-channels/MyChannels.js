import {getChannel} from '/js/shared-components/Channel.js';

let channels = document.getElementById('channels');

let url = document.URL.split("/");
let userName = url[4];

for(let i = 0; i < 5; i++) {
  channels.append(getChannel("Cursed FEUP", 15, 420, "default-background.jpg"));
}
