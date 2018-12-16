export function getChannel(name, numPosts, numSubs, banner) {

    let channel = document.createElement("div");
    channel.className = "channel-comp-container";
    channel.innerHTML = `
      <a href="/channel">
        <div class="channel-background" style="background-image: url('/assets/images/channels/default-background.jpg')"></div>

        <div class="channel-name">
        </div>

        <div class="channel-posts-num">
        </div>

        <div class="channel-subs">
        </div>
      </a>
    `;

    channel.querySelector(".channel-name").textContent = name;
    channel.querySelector(".channel-posts-num").textContent = "Posts: " + numPosts;
    channel.querySelector(".channel-subs").textContent = "Subscriptions: " + numSubs;
    channel.querySelector(".channel-background").style.backgroundImage = "url('/assets/images/channels/" + banner + "')";

    return channel;
}
