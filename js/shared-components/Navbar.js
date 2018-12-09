let avatar = document.querySelector(".user-avatar");

avatar.addEventListener("click", function() {
  let options = document.querySelector(".options-layout");

  if (options.hidden) {
    options.hidden = false;
    options.focus();
  }
  else {
    options.hidden = true;
  }
});

let options = document.querySelector(".options-layout");
options.addEventListener("blur", function() {
  options.hidden = true;
});
