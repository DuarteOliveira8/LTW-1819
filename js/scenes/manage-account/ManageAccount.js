
function fillGeneralInfoForm(uName, fName, lName, uBio, bDay, bMonth, bYear, email, avatar) {

  document.getElementsByName("username")[0].value = uName;
  document.getElementsByName("first-name")[0].value = fName;
  document.getElementsByName("last-name")[0].value = lName;
  document.getElementsByName("user-bio")[0].value = uBio;
  document.getElementsByName("day")[0][bDay].selected = bDay;
  document.getElementsByName("month")[0][bMonth].selected = bMonth;
  document.getElementsByName("year")[0][bYear-1920+1].selected = bYear;
  document.getElementsByName("email")[0].value = email;
  document.getElementsByName("avatar")[0].style.backgroundImage = "url('/assets/images/users/"+avatar+"')";
}



let fillGeneralRequest = new XMLHttpRequest();

fillGeneralRequest.onreadystatechange = function() {
  if (this.readyState === 4 && this.status === 200) {
    let response = JSON.parse(this.responseText);
    let date = response.data.birthDate;
    let parsedDate = date.split("-");
    
    let year = parsedDate[0];
    let month = parsedDate[1];
    let day = parsedDate[2];

    fillGeneralInfoForm(response.data.username, response.data.firstName, response.data.lastName, response.data.bio, day, month, year, response.data.email, response.data.avatar);
    
  }
}


fillGeneralRequest.open("GET", "/api/user/" + username, true);
fillGeneralRequest.send();
