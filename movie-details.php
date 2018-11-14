<?php 
session_start();
include('includes/config.php');
error_reporting(0);
if(isset($_POST['submit']))
{
$fromdate=$_POST['fromdate'];
$todate=$_POST['todate']; 
$message=$_POST['message'];
$useremail=$_SESSION['login'];
$status=0;
$movieid=$_GET['mvid'];
$sql="INSERT INTO  tblbooking(UserEmail,MovieId,FromDate,ToDate,Message,Status) VALUES(:useremail,:movieid,:fromdate,:todate,:message,:status)";
$query = $dbh->prepare($sql);
$query->bindParam(':useremail',$useremail,PDO::PARAM_STR);
$query->bindParam(':movieid',$movieid,PDO::PARAM_STR);
$query->bindParam(':fromdate',$fromdate,PDO::PARAM_STR);
$query->bindParam(':todate',$todate,PDO::PARAM_STR);
$query->bindParam(':message',$message,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
echo "<script>alert('Udało się zamówić film.');
      location.href = 'my-booking.php';
</script>";
}
else 
{
echo "<script>alert('Coś poszło nie tak. Spróbuj ponownie');</script>";
}

}

?>


<!DOCTYPE HTML>
<html lang="pl">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="keywords" content="">
<meta name="description" content="">
<title>Wypożyczalnia Filmów</title>
<!--Bootstrap -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<!--Custome Style -->
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<!--OWL Carousel slider-->
<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
<!--slick-slider -->
<link href="assets/css/slick.css" rel="stylesheet">
<!--bootstrap-slider -->
<link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
<!--FontAwesome Font Style -->
<link href="assets/css/font-awesome.min.css" rel="stylesheet">

<link href="assets/switcher/css/blue.css" rel="stylesheet">

<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
<!-- DATE PICKER STYLES -->
<link href="assets/css/datepicker.css" rel="stylesheet" type="text/css"/>
</head>
<body>

<!--Header-->
<?php include('includes/header.php');?>
<!-- /Header --> 

<!--Listing-Image-Slider-->

<?php 
$mvid=intval($_GET['mvid']);
$sql = "SELECT tblmovies.*,tblgenre.GenreName,tblgenre.id as gid  from tblmovies join tblgenre on tblgenre.id=tblmovies.moviesGenre where tblmovies.id=:mvid";
$query = $dbh -> prepare($sql);
$query->bindParam(':mvid',$mvid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  
$_SESSION['genredid']=$result->gid;  
?>  

<section id="listing_img_slider">
  <div><img src="admin/img/movieimages/<?php echo htmlentities($result->Vimage1);?>" class="img-responsive" alt="image" width="900" height="560"></div>
  <?php if($result->Vimage2=="")
{

} else {
  ?>
  <div><img src="admin/img/movieimages/<?php echo htmlentities($result->Vimage2);?>" class="img-responsive" alt="image" width="900" height="560"></div>
  <?php } ?>
  <?php if($result->Vimage3=="")
{

} else {
  ?>
  <div><img src="admin/img/movieimages/<?php echo htmlentities($result->Vimage3);?>" class="img-responsive" alt="image" width="900" height="560"></div>
  <?php } ?>
  <?php if($result->Vimage4=="")
{

} else {
  ?>
  <div><img src="admin/img/movieimages/<?php echo htmlentities($result->Vimage4);?>" class="img-responsive" alt="image" width="900" height="560"></div>
  <?php } ?>
  <?php if($result->Vimage5=="")
{

} else {
  ?>
  <div><img src="admin/img/movieimages/<?php echo htmlentities($result->Vimage5);?>" class="img-responsive" alt="image" width="900" height="560"></div>
  <?php } ?>
</section>
<!--/Listing-Image-Slider-->


<!--Listing-detail-->
<section class="listing-detail">
  <div class="container">
    <div class="listing_detail_head row">
      <div class="col-md-9">
        <h2><?php echo htmlentities($result->GenreName);?> , <?php echo htmlentities($result->MoviesTitle);?></h2>
      </div>
      <div class="col-md-3">
        <div class="price_info">
          <p><?php echo htmlentities($result->PricePerDay);?>zł /Dzień</p>
         
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-9">
        <div class="main_features">
          <ul>
          
            <li> <i class="fa fa-calendar" aria-hidden="true"></i>
              <h5><?php echo htmlentities($result->MovieYear);?></h5>
              <p>Rok Produkcji</p>
            </li>
            <li> <i class="fa fa-clone" aria-hidden="true"></i>
              <h5><?php echo htmlentities($result->GenreName);?></h5>
              <p>Gatunek</p>
            </li>
       
            <li> <i class="fa fa-clock-o" aria-hidden="true"></i>
              <h5><?php echo htmlentities($result->Duration);?></h5>
              <p>Czas Trwania [min]</p>
            </li>
          </ul>
        </div>
        <div class="listing_more_info">
          <div class="listing_detail_wrap"> 
            <!-- Nav tabs -->
            <ul class="nav nav-tabs gray-bg" role="tablist">
              <li role="presentation" class="active"><a href="#movie-overview " aria-controls="movie-overview" role="tab" data-toggle="tab">Opis Filmu</a></li>
              <li role="presentation"><a href="#actors" aria-controls="actors" role="tab" data-toggle="tab">Aktorzy</a></li>
              <li role="presentation"><a href="#directors" aria-controls="directors" role="tab" data-toggle="tab">Reżyserzy</a></li>
              <li role="presentation"><a href="#country" aria-controls="country" role="tab" data-toggle="tab">Kraj Produkcji</a></li>
            </ul>
            
            <!-- Tab panes -->
            <div class="tab-content"> 
              <!-- Movie-overview -->
              <div role="tabpanel" class="tab-pane active" id="movie-overview">
                
                <p><?php echo htmlentities($result->MoviesOverview);?></p>
              </div>             
              
              <!-- Actors -->
              <div role="tabpanel" class="tab-pane" id="actors"> 
                <!--Actors -->
                <p><?php echo htmlentities($result->Actors);?></p>
              </div>

              <!-- Country -->
              <div role="tabpanel" class="tab-pane" id="country"> 
                <!--Country -->
                <p><?php echo htmlentities($result->Country);?></p>
              </div>

              <!-- Directors -->
              <div role="tabpanel" class="tab-pane" id="directors"> 
                <!--Directors -->
                <p><?php echo htmlentities($result->Directors);?></p>

              </div>
            </div>
          </div>
        </div>
<?php }} ?>
   
      </div>
      
      <!--Side-Bar-->
      <aside class="col-md-3">
        <div class="sidebar_widget">
          <div class="widget_heading">
            <h5><i class="fa fa-envelope" aria-hidden="true"></i>Zamów Teraz</h5>
          </div>
          <form method="post">
            <div class="form-group">
              <input id="fromDate" autocomplete="off" type="text" class="form-control" name="fromdate" placeholder="Od(dd/mm/yyyy)" required>
            </div>
            <div class="form-group">
              <input id="toDate"  autocomplete="off" type="text" class="form-control" name="todate" placeholder="Do(dd/mm/yyyy)" required>
            </div>
            <div class="form-group">
              <textarea rows="4" class="form-control" name="message" placeholder="Wiadomość (opcjonalnie)"></textarea>
            </div>
          <?php if($_SESSION['login'])
              {?>
              <div class="form-group">
                <input type="submit" class="btn" name="submit" value="Zamów Teraz">
              </div>
              <?php } else { ?>
<a href="#loginform" class="btn btn-xs uppercase" data-toggle="modal" data-dismiss="modal">Zaloguj Aby Zamówić</a>

              <?php } ?>
          </form>
        </div>
      </aside>
      <!--/Side-Bar--> 
    </div>
    
    <div class="space-20"></div>
    <div class="divider"></div>
    
    <!--Similar-Cars-->
    <div class="similar_cars">
      <h3>Podobne Filmy</h3>
      <div class="row">
<?php 
$gid=$_SESSION['genreid'];
$sql="SELECT tblmovies.MoviesTitle,tblmovies.Duration,tblgenre.GenreName,tblmovies.PricePerDay,tblmovies.MovieYear,tblmovies.id,tblmovies.MoviesOverview,tblmovies.Vimage1 from tblmovies join tblgenre on tblgenre.id=tblmovies.MoviesGenre where tblmovies.MoviesGenre=:gid";
$query = $dbh -> prepare($sql);
$query->bindParam(':gid',$gid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{ ?>      
        <div class="col-md-3 grid_listing">
          <div class="product-listing-m gray-bg">
            <div class="product-listing-img"> <a href="movie-details.php?mvid=<?php echo htmlentities($result->id);?>"><img src="admin/img/movieimages/<?php echo htmlentities($result->Vimage1);?>" class="img-responsive" alt="image" /> </a>
            </div>
            <div class="product-listing-content">
              <h5><a href="movie-details.php?mvid=<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->GenreName);?> , <?php echo htmlentities($result->MoviesTitle);?></a></h5>
              <p class="list-price"><?php echo htmlentities($result->PricePerDay);?>zł /Dzień</p>
          
              <ul class="features_list">
                
              <li><i class="fa fa-newspaper-o" aria-hidden="true"></i><?php echo htmlentities($result->MoviesTitle);?></li>
              <li><i class="fa fa-calendar" aria-hidden="true"></i><?php echo htmlentities($result->MovieYear);?></li>
              <li><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo htmlentities($result->Duration);?> min</li>
              </ul>
            </div>
          </div>
        </div>
 <?php }} ?>       

      </div>
    </div>
    <!--/Similar-Cars--> 
    
  </div>
</section>
<!--/Listing-detail--> 

<!--Footer -->
<?php include('includes/footer.php');?>
<!-- /Footer--> 

<!--Back to top-->
<div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
<!--/Back to top--> 

<!--Login-Form -->
<?php include('includes/login.php');?>
<!--/Login-Form --> 

<!--Register-Form -->
<?php include('includes/registration.php');?>

<!--/Register-Form --> 

<!--Forgot-password-Form -->
<?php include('includes/forgotpassword.php');?>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/interface.js"></script> 

<script src="assets/js/bootstrap-slider.min.js"></script> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/owl.carousel.min.js"></script>
<script type="text/javascript" src="assets/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="assets/js/jquery-ui-1.8.18.custom.min.js"></script>
<script src="assets/js/date_picker.js"></script>

</body>
</html>