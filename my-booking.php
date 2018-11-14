<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
  { 
header('location:index.php');
}
else{
?><!DOCTYPE HTML>
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
<!-- Fav and touch icons -->
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/favicon-icon/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/favicon-icon/apple-touch-icon-114-precomposed.html">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/favicon-icon/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="assets/images/favicon-icon/apple-touch-icon-57-precomposed.png">
<link rel="shortcut icon" href="assets/images/favicon-icon/favicon.png">
<!-- Google-Font-->
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->  
</head>
<body>

<!--Header-->
<?php include('includes/header.php');?>
<!--Page Header-->
<!-- /Header --> 

<!--Page Header-->
<section class="page-header profile_page">
  <div class="container">
    <div class="page-header_wrap">
      <div class="page-heading">
        <h1>Moje Zamówienia</h1>
      </div>
      <ul class="coustom-breadcrumb">
        <li><a href="index.php">Strona Główna</a></li>
        <li>Moje Zamówienia</li>
      </ul>
    </div>
  </div>
</section>
<!-- /Page Header--> 

<?php 
$useremail=$_SESSION['login'];
$sql = "SELECT * from tblusers where EmailId=:useremail";
$query = $dbh -> prepare($sql);
$query -> bindParam(':useremail',$useremail, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{ 
  ?>
<section class="user_profile inner_pages">
  <div class="container">
    <div class="user_profile_info gray-bg padding_4x4_40">
      <div class="upload_user_logo"> <img src="assets/images/user-logo.png" alt="image">
      </div>

      <div class="dealer_info">
        <h5><?php echo htmlentities($result->FullName);?></h5>
        <p><?php echo htmlentities($result->Address);?><br>
          <?php echo htmlentities($result->City);?>&nbsp;<?php echo htmlentities($result->Country); }}?></p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3 col-sm-3">
       <?php include('includes/sidebar.php');?>
   
      <div class="col-md-8 col-sm-8">
        <div class="profile_wrap">
          <h5 class="uppercase underline">Moje Zamówienia</h5>
          <div class="my_movies_list">
            <ul class="movie_listing">
<?php 
$useremail=$_SESSION['login'];
$sql = "SELECT tblmovies.Vimage1 as Vimage1,tblmovies.MoviesTitle,tblmovies.id as vid,tblgenre.GenreName,tblbooking.FromDate,tblbooking.ToDate,tblbooking.Message,tblbooking.Status from tblbooking join tblmovies on tblbooking.MovieId=tblmovies.id join tblgenre on tblgenre.id=tblmovies.MoviesGenre where tblbooking.UserEmail=:useremail";
$query = $dbh -> prepare($sql);
$query-> bindParam(':useremail', $useremail, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  ?>

<li>
  <div class="movie_img"> <a href="movie-details.php?mvid=<?php echo htmlentities($result->vid);?>"><img src="admin/img/movieimages/<?php echo htmlentities($result->Vimage1);?>" alt="image"></a> </div>
     <div class="movie_title">
        <h6><a href="movie-details.php?mvid=<?php echo htmlentities($result->vid);?>"> <?php echo htmlentities($result->GenreName);?> , <?php echo htmlentities($result->MoviesTitle);?></a></h6>
        <p><b>Od Dnia:</b> <?php echo htmlentities($result->FromDate);?><br /> <b>Do Dnia:</b> <?php echo htmlentities($result->ToDate);?></p>
        <div style="float: left"><p><b>Wiadomość:</b> <?php echo htmlentities($result->Message);?> </p></div>
        </div>
      <?php if($result->Status==1)
      { ?>
      <div class="movie_status"> <a class="btn outline btn-xs active-btn">Potwierdzono</a>
        <div class="clearfix"></div>
        </div>
        <?php } else if($result->Status==2) { ?>
    <div class="movie_status"> <a class="btn outline btn-xs">Anulowano</a>
      <div class="clearfix"></div>
    </div>
      <?php } else { ?>
    <div class="movie_status"> <a class="btn outline btn-xs">Czeka na potwierdzenie</a>
            <div class="clearfix"></div>
    </div>
          <?php } ?>
  </li>
  <?php }} ?>
             
         
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--/my-movies--> 
<?php include('includes/footer.php');?>

<!-- Scripts --> 
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/interface.js"></script> 


<!--bootstrap-slider-JS--> 
<script src="assets/js/bootstrap-slider.min.js"></script> 
<!--Slider-JS--> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/owl.carousel.min.js"></script>
</body>
</html>
<?php } ?>