<header>
  <div class="default-header">
    <div class="container">
      <div class="row">
        <div class="col-sm-3 col-md-2">
          <div class="logo"> <a href="index.php"><img src="assets/images/logo.png" alt="image"/></a> </div>
        </div>
        <div class="col-sm-9 col-md-10">
          <div class="header_info">
            <div class="header_widgets">
              <div class="circle_icon"> <i class="fa fa-envelope" aria-hidden="true"></i> </div>
              <p class="uppercase_text">Kontakt Mailowy: </p>
              <a href="mailto:movie@gmail.com">movie@gmail.com</a> </div>
            <div class="header_widgets">
              <div class="circle_icon"> <i class="fa fa-phone" aria-hidden="true"></i> </div>
              <p class="uppercase_text">Serwis telefoniczny: </p>
              <a href="tel:123456789">123456789</a> </div>
            <div class="social-follow">
              <ul>
                <li><a href="https://pl-pl.facebook.com/"><i class="fa fa-facebook-square" aria-hidden="true"></i></a></li>
                <li><a href="https://www.instagram.com/"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
              </ul>
            </div>
   <?php   if(strlen($_SESSION['login'])==0)
	{	
?>
 <div class="login_btn"> <a href="#loginform" class="btn btn-xs uppercase" data-toggle="modal" data-dismiss="modal">Logowanie/ Rejestracja</a> </div>
<?php }
else{ 
  $email=$_SESSION['login'];
  $sql ="SELECT FullName FROM tblusers WHERE EmailId=:email ";
  $query= $dbh -> prepare($sql);
  $query-> bindParam(':email', $email, PDO::PARAM_STR);
  $query-> execute();
  $results=$query->fetchAll(PDO::FETCH_OBJ);
  if($query->rowCount() > 0)
  {
    foreach ($results as $result) {
      $name = htmlentities(explode(" ", $result->FullName)[0]);
        echo "<span style='color:#157cb8;text-decoration: underline;'>".$name."</span>".", witaj w naszej wypożyczalni!";
    }
  }
 } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Navigation -->
  <nav id="navigation_bar" class="navbar navbar-default">
    <div class="container">
      <div class="navbar-header">
        <button id="menu_slide" data-target="#navigation" aria-expanded="false" data-toggle="collapse" class="navbar-toggle collapsed" type="button"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      </div>
      <div class="header_wrap">
        <div class="user_login">
          <ul>
            <li class="dropdown"> <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle" aria-hidden="true"></i> 
<?php 
$email=$_SESSION['login'];
$sql ="SELECT FullName FROM tblusers WHERE EmailId=:email ";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
	{

	 echo htmlentities($result->FullName); }}?><i class="fa fa-angle-down" aria-hidden="true"></i></a>
              <ul class="dropdown-menu">
           <?php if($_SESSION['login']){?>
            <li><a href="profile.php">Ustawienia Profilu</a></li>
              <li><a href="update-password.php">Zmień Hasło</a></li>
            <li><a href="my-booking.php">Moje Zamówienia</a></li>
            <li><a href="post-testimonial.php">Wstaw Opinię</a></li>
          <li><a href="my-testimonials.php">Moje Opinie</a></li>
            <li><a href="logout.php">Wyloguj Się</a></li>
            <?php } else { ?>
            <li><a href="#loginform"  data-toggle="modal" data-dismiss="modal">Ustawienia Profilu</a></li>
              <li><a href="#loginform"  data-toggle="modal" data-dismiss="modal">Zmień Hasło</a></li>
            <li><a href="#loginform"  data-toggle="modal" data-dismiss="modal">Moje Zamówienia</a></li>
            <li><a href="#loginform"  data-toggle="modal" data-dismiss="modal">Wstaw Opinię</a></li>
          <li><a href="#loginform"  data-toggle="modal" data-dismiss="modal">Moje Opinie</a></li>
            <li><a href="#loginform"  data-toggle="modal" data-dismiss="modal">Wyloguj Się</a></li>
            <?php } ?>
          </ul>
            </li>
          </ul>
        </div>
      </div>
      <div class="collapse navbar-collapse" id="navigation">
        <ul class="nav navbar-nav">
          <li><a href="index.php">Strona Główna</a></li>	 
          <li><a href="page.php?type=aboutus">O nas</a></li>
          <li><a href="movie-listing.php">Lista Filmów</a>
          <li><a href="contact-us.php">Kontakt</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Navigation end --> 
  
</header>