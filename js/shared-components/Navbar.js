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
document.getElementById("submitButton").onclick= function(){
  var link = document.querySelector("input[name='search']").value;
  window.location.href = "/search/"+link;
}

options.addEventListener("blur", function() {
  options.hidden = true;
});
