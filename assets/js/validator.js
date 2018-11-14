function checkAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'emailid='+$("#emailid").val(),
type: "POST",
success:function(data){
$("#user-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
function valid()
{
if(document.signup.password.value!= document.signup.confirmpassword.value)
{
alert("Hasła nie są takie same!");
document.signup.confirmpassword.focus();
return false;
}
return true;
}