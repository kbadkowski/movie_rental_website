<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{ 

if(isset($_POST['submit']))
  {
$movietitle=$_POST['movietitle'];
$genre=$_POST['GenreName'];
$movieoverview=$_POST['movieover'];
$priceperday=$_POST['priceperday'];
$movieYear=$_POST['movieYear'];
$vimage1=$_FILES["img1"]["name"];
$vimage2=$_FILES["img2"]["name"];
$vimage3=$_FILES["img3"]["name"];
$vimage4=$_FILES["img4"]["name"];
$vimage5=$_FILES["img5"]["name"];
$actors=$_POST['actors'];
$directors=$_POST['directors'];
$country=$_POST['country'];
$duration=$_POST['duration'];
move_uploaded_file($_FILES["img1"]["tmp_name"],"img/movieimages/".$_FILES["img1"]["name"]);
move_uploaded_file($_FILES["img2"]["tmp_name"],"img/movieimages/".$_FILES["img2"]["name"]);
move_uploaded_file($_FILES["img3"]["tmp_name"],"img/movieimages/".$_FILES["img3"]["name"]);
move_uploaded_file($_FILES["img4"]["tmp_name"],"img/movieimages/".$_FILES["img4"]["name"]);
move_uploaded_file($_FILES["img5"]["tmp_name"],"img/movieimages/".$_FILES["img5"]["name"]);

$sql="INSERT INTO tblmovies(MoviesTitle,MoviesGenre,MoviesOverview,Actors,Directors,Country,PricePerDay,MovieYear,Duration,Vimage1,Vimage2,Vimage3,Vimage4,Vimage5) VALUES(:movietitle,:genre,:movieoverview,:actors,:directors,:country,:priceperday,:movieYear,:duration,:vimage1,:vimage2,:vimage3,:vimage4,:vimage5)";
$query = $dbh->prepare($sql);
$query->bindParam(':movietitle',$movietitle,PDO::PARAM_STR);
$query->bindParam(':genre',$genre,PDO::PARAM_STR);
$query->bindParam(':movieoverview',$movieoverview,PDO::PARAM_STR);
$query->bindParam(':priceperday',$priceperday,PDO::PARAM_STR);
$query->bindParam(':movieYear',$movieYear,PDO::PARAM_STR);
$query->bindParam(':vimage1',$vimage1,PDO::PARAM_STR);
$query->bindParam(':vimage2',$vimage2,PDO::PARAM_STR);
$query->bindParam(':vimage3',$vimage3,PDO::PARAM_STR);
$query->bindParam(':vimage4',$vimage4,PDO::PARAM_STR);
$query->bindParam(':vimage5',$vimage5,PDO::PARAM_STR);
$query->bindParam(':actors',$actors,PDO::PARAM_STR);
$query->bindParam(':directors',$directors,PDO::PARAM_STR);
$query->bindParam(':country',$country,PDO::PARAM_STR);
$query->bindParam(':duration',$duration,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Film został dodany pomyślnie";
}
else 
{
$error="Coś poszło nie tak. Spróbuj ponownie";
}

}


	?>
<!doctype html>
<html lang="pl" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	
	<title>Wypożyczalnia Filmów</title>

	<!-- Font awesome -->
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- Sandstone Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Bootstrap Datatables -->
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<!-- Bootstrap social button library -->
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<!-- Bootstrap select -->
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<!-- Bootstrap file input -->
	<link rel="stylesheet" href="css/fileinput.min.css">
	<!-- Awesome Bootstrap checkbox -->
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<!-- Admin Stye -->
	<link rel="stylesheet" href="css/style.css">
</head>

<body>
	<?php include('includes/header.php');?>
	<div class="ts-main-content">
	<?php include('includes/leftbar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">
					
						<h2 class="page-title">Wstaw Film</h2>

						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">Podstawowe Informacje</div>
<?php if($error){?><div class="errorWrap"><strong>Błąd </strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>Sukces </strong>:<?php echo htmlentities($msg); ?> </div><?php }?>

									<div class="panel-body">
<form method="post" class="form-horizontal" enctype="multipart/form-data">
<div class="form-group">
<label class="col-sm-2 control-label">Tytuł Filmu<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="movietitle" class="form-control" required>
</div>
<label class="col-sm-2 control-label">Wybierz Gatunek<span style="color:red">*</span></label>
<div class="col-sm-4">
<select class="selectpicker" name="GenreName" required>
<option value="">Wybierz</option>
<?php $ret="select id,GenreName from tblgenre";
$query= $dbh -> prepare($ret);
//$query->bindParam(':id',$id, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
foreach($results as $result)
{
?>
<option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->GenreName);?></option>
<?php }} ?>

</select>
</div>
</div>
											
<div class="hr-dashed"></div>
<div class="form-group">
<label class="col-sm-2 control-label">Szczegóły Filmu<span style="color:red">*</span></label>
<div class="col-sm-10">
<textarea class="form-control" name="movieover" rows="3" required></textarea>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Cena na Dzień [PLN]<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="priceperday" class="form-control" required>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Data Wydania<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="movieYear" class="form-control" required>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Czas Trwania [min]<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="duration" class="form-control" required>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Aktorzy<span style="color:red">*</span></label>
<div class="col-sm-10">
<textarea class="form-control" name="actors" rows="2" required></textarea>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Reżyserzy<span style="color:red">*</span></label>
<div class="col-sm-6">
<input type="text" name="directors" class="form-control" required>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Kraj Produkcji<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="country" class="form-control" required>
</div>
</div>

<div class="form-group">
<div class="col-sm-12">
<h4><b>Wstaw Obrazy</b></h4>
</div>
</div>


<div class="form-group">
<div class="col-sm-4">
Obraz 1<span style="color:red">*</span><input type="file" name="img1" required>
</div>
<div class="col-sm-4">
Obraz 2<input type="file" name="img2">
</div>
<div class="col-sm-4">
Obraz 3<input type="file" name="img3">
</div>
</div>


<div class="form-group">
<div class="col-sm-4">
Obraz 4<input type="file" name="img4">
</div>
<div class="col-sm-4">
Obraz 5<input type="file" name="img5">
</div>

</div>
<div class="hr-dashed"></div>									
</div>
</div>
</div>
</div>
							


</div>




											<div class="form-group">
												<div class="col-sm-8 col-sm-offset-2">
													<button class="btn btn-default" type="reset">Anuluj</button>
													<button class="btn btn-primary" name="submit" type="submit">Zapisz Zmiany</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						
					

					</div>
				</div>
				
			

			</div>
		</div>
	</div>

	<!-- Loading Scripts -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>
</body>
</html>
<?php } ?>