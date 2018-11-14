<?php
//error_reporting(0);
if(isset($_POST['signup']))
{
$fname=ucwords($_POST['fullname']);
$email=strtolower($_POST['emailid']); 
$password=md5($_POST['password']); 
$sql="INSERT INTO  tblusers(FullName,EmailId,Password) VALUES(:fname,:email,:password)";
$query = $dbh->prepare($sql);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':password',$password,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
echo "<script>alert('Rejestracja zakończona sukcesem. Możesz się zalogować');</script>";
}
else 
{
echo "<script>alert('Coś poszło nie tak. Spróbuj ponownie');</script>";
}
}

?>
<script src="assets/js/validator.js"></script> 
<div class="modal fade" id="signupform">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h3 class="modal-title">Zarejestruj Się</h3>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="signup_wrap">
            <div class="col-md-12 col-sm-6">
              <form  method="post" name="signup" onSubmit="return valid();">
                <div class="form-group">
                  <input type="text" class="form-control" name="fullname" placeholder="Imię i Nazwisko*" required="required">
                </div>                      
                <div class="form-group">
                  <input type="email" class="form-control" name="emailid" id="emailid" onBlur="checkAvailability()" placeholder="Adres Email*" required="required">
                   <span id="user-availability-status" style="font-size:12px;"></span> 
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" name="password" placeholder="Hasło*" required="required">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" name="confirmpassword" placeholder="Potwierdź Hasło*" required="required">
                </div>
                <div class="form-group checkbox">
                  <input type="checkbox" id="terms_agree" required="required">
                  <label for="terms_agree">Zgadzam się z <a href="page.php?type=terms">regulaminem</a>*</label>
                </div>
                <div class="form-group">
                  <input type="submit" value="Zarejestruj Się" name="signup" id="submit" class="btn btn-block">
                </div>
              </form>
            </div>
            
          </div>
        </div>
      </div>
      <div class="modal-footer text-center">
        <p>Masz już konto? <a href="#loginform" data-toggle="modal" data-dismiss="modal">Zaloguj Się</a></p>
      </div>
    </div>
  </div>
</div>