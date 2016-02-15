$(document).ready(function(){
  //alert('Hello World!');
});
function password_matches_confirmation(){
	if(document.getElementById("password").value!=document.getElementById("password2").value){
		alert("Password does not match confirmation.");
		return false;
	}
}