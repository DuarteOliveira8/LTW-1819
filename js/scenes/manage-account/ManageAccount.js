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



let updateAccount = new XMLHttpRequest();

updateAccount.onreadystatechange = function() {

    if (this.readyState === 4 && this.status === 200) {
      let response = JSON.parse(this.responseText);
      if(!response.sucess){
        console.log(response);
        return;
      }
      let date = response.data.birthDate;
      let parsedDate = date.split("-");

      let year = parsedDate[0];
      let month = parsedDate[1];
      let day = parsedDate[2];

      fillGeneralInfoForm(response.data.username, response.data.firstName, response.data.lastName, response.data.bio, day, month, year, response.data.email, response.data.avatar);

  }
}

document.getElementById("submitInfo").onclick= function(){
  var user = document.querySelector("input[name='username']").value;
  var fName = document.querySelector("input[name='first-name']").value;
  var lName = document.querySelector("input[name='last-name']").value;
  var userbio = document.querySelector("textarea[name='user-bio']").value;

  var daySelect = document.querySelector("select[name='day']");
  var day = daySelect[daySelect.selectedIndex].value;
  var monthSelect = document.querySelector("select[name='month']");
  var month = monthSelect[monthSelect.selectedIndex].value;
  var yearSelect = document.querySelector("select[name='year']");
  var year = yearSelect[yearSelect.selectedIndex].value;
  var bday= year + "-" + month + "-" + day;
  var email = document.querySelector("input[name='email']").value;

  var info={"username": user, "firstName": fName, "lastName": lName, "bio": userbio, "birthDate": bday, "email":email}
  let response = JSON.stringify(info);
  updateAccount.open("POST", "/api/user/" + username, true);
  updateAccount.setRequestHeader("csrf",csrf);
  updateAccount.send(response);
}

let updatePassword = new XMLHttpRequest();

document.getElementById("submitPassword").onclick= function() {
  var currpassword = document.querySelector("input[name='current-password']").value;
  var password = document.querySelector("input[name='password']").value;
  var confirmpassword = document.querySelector("input[name='confirm-password']").value;
  var infopass={"current-password": currpassword, "password": password, "confirm-password": confirmpassword}
  let response = JSON.stringify(infopass);
  updatePassword.open("POST", "/api/user/" + username + "/password", true);
  updatePassword.setRequestHeader("csrf",csrf);
  updatePassword.send(response);
}
