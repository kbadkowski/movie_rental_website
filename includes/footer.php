<?php
if(isset($_POST['emailsubscibe']))
{
$subscriberemail=$_POST['subscriberemail'];
$sql ="SELECT SubscriberEmail FROM tblsubscribers WHERE SubscriberEmail=:subscriberemail";
$query= $dbh -> prepare($sql);
$query-> bindParam(':subscriberemail', $subscriberemail, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query -> rowCount() > 0)
{
echo "<script>alert('Already Subscribed.');</script>";
}
else{
$sql="INSERT INTO  tblsubscribers(SubscriberEmail) VALUES(:subscriberemail)";
$query = $dbh->prepare($sql);
$query->bindParam(':subscriberemail',$subscriberemail,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
echo "<script>alert('Subscribed successfully.');</script>";
}
else 
{
echo "<script>alert('Coś poszło nie tak. Spróbuj ponownie');</script>";
}
}
}
?>

<footer>
  <div class="footer-top">
    <div class="container">
      <div class="row">
      
        <div class="col-md-6">
          <h6>O Nas</h6>
          <ul>
          <li><a href="page.php?type=aboutus">O Nas</a></li>
            <li><a href="page.php?type=privacy">Polityka Prywatności</a></li>
          <li><a href="page.php?type=terms">Regulamin</a></li>
          </ul>
        </div>
  
        <div class="col-md-3 col-sm-6">
          <h6>Zapisz Się Do Newslettera</h6>
          <div class="newsletter-form">
            <form method="post">
              <div class="form-group">
                <input type="email" name="subscriberemail" class="form-control newsletter-input" required placeholder="Podaj Adres Email" />
              </div>
              <button type="submit" name="emailsubscibe" class="btn btn-block">Subskrybuj <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-push-6 text-right">
          <div class="footer_widget">
            <p>Połącz się z nami:</p>
            <ul>
              <li><a href="https://pl-pl.facebook.com/"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
              <li><a href="https://www.instagram.com/"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
            </ul>
          </div>
        </div>
        <div class="col-md-6 col-md-pull-6">
          <p class="copy-right">Copyright &copy; 2018 Wypożyczalnia Filmów. Wszystkie Prawa Zastrzeżone</p>
        </div>
      </div>
    </div>
  </div>
</footer>