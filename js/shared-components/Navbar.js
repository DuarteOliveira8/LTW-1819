let avatar = document.querySelector(".user-avatar");
let options = document.querySelector(".options-layout");

avatar.addEventListener("click", function() {
  if (options.hidden) {
    options.hidden = false;
    options.focus();
  }
  else {
    options.hidden = true;
  }
});

options.addEventListener("blur", function() {
  options.hidden = true;
});
