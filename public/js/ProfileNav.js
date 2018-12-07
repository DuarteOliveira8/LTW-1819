var pages = document.querySelectorAll(".tab-container");
var tabs = document.querySelectorAll(".profile-tab");

function hideAll() {
  for (var i = 0; i < pages.length; i++) {
    pages[i].hidden = true;
  }
}

function unselect() {
  for (var i = 0; i < tabs.length; i++) {
    tabs[i].classList.remove("selected");
  }
}

tabs.forEach(function(tab, index) {
  tab.addEventListener("click", function() {
    hideAll();
    unselect();
    pages[index].hidden = false;
    tabs[index].classList.add("selected");
  });
});
