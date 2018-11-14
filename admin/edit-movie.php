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
$actors=$_POST['actors'];
$directors=$_POST['directors'];
$country=$_POST['country'];
$duration=$_POST['duration'];
$id=intval($_GET['id']);

$sql="update tblmovies set MoviesTitle=:movietitle,MoviesGenre=:genre,MoviesOverview=:movieoverview,Actors=:actors,Directors=:directors,Country=:country,PricePerDay=:priceperday,MovieYear=:movieyear,Duration=:duration where id=:id ";
$query = $dbh->prepare($sql);
$query->bindParam(':movietitle',$movietitle,PDO::PARAM_STR);
$query->bindParam(':genre',$genre,PDO::PARAM_STR);
$query->bindParam(':movieoverview',$movieoverview,PDO::PARAM_STR);
$query->bindParam(':priceperday',$priceperday,PDO::PARAM_STR);
$query->bindParam(':movieYear',$movieYear,PDO::PARAM_STR);
$query->bindParam(':actors',$actors,PDO::PARAM_STR);
$query->bindParam(':directors',$directors,PDO::PARAM_STR);
$query->bindParam(':country',$country,PDO::PARAM_STR);
$query->bindParam(':duration',$duration,PDO::PARAM_STR);
$query->bindParam(':id',$id,PDO::PARAM_STR);
$query->execute();

$msg="Dane zaktualizowane pomyślnie";


}


	?>
<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	
	<title>Wypoyczalnia Filmów</title>

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
	<style>
		</style>
</head>

<body>
	<?php include('includes/header.php');?>
	<div class="ts-main-content">
	<?php include('includes/leftbar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">
					
						<h2 class="page-title">Edytuj Film</h2>

						<div class="row">
							<div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-heading">Podstawowe Informacje</div>
									<div class="panel-body">
<?php if($msg){?><div class="succWrap"><strong>Sukces </strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
<?php 
$id=intval($_GET['id']);
$sql ="SELECT tblmovies.*,tblgenre.GenreName,tblgenre.id as gid from tblmovies join tblgenre on tblgenre.id=tblmovies.MoviesGenre where tblmovies.id=:id";
$query = $dbh -> prepare($sql);
$query-> bindParam(':id', $id, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{	?>

<form method="post" class="form-horizontal" enctype="multipart/form-data">
<div class="form-group">
<label class="col-sm-2 control-label">Tytuł Filmu<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="movietitle" class="form-control" value="<?php echo htmlentities($result->MoviesTitle)?>" required>
</div>
<label class="col-sm-2 control-label">Wybierz Gatunek<span style="color:red">*</span></label>
<div class="col-sm-4">
<select class="selectpicker" name="genrename" required>
<option value="<?php echo htmlentities($result->gid);?>"><?php echo htmlentities($bdname=$result->GenreName); ?> </option>
<?php $ret="select id,GenreName from tblgenre";
$query= $dbh -> prepare($ret);
//$query->bindParam(':id',$id, PDO::PARAM_STR);
$query-> execute();
$resultss = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
foreach($resultss as $results)
{
if($results->GenreName==$bdname)
{
continue;
} else{
?>
<option value="<?php echo htmlentities($results->id);?>"><?php echo htmlentities($results->GenreName);?></option>
<?php }}} ?>

</select>
</div>
</div>
											
<div class="hr-dashed"></div>
<div class="form-group">
<label class="col-sm-2 control-label">Opis Filmu<span style="color:red">*</span></label>
<div class="col-sm-10">
<textarea class="form-control" name="vehicalorcview" rows="3" required><?php echo htmlentities($result->MoviesOverview);?></textarea>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Cena na Dzień [PLN]<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="priceperday" class="form-control" value="<?php echo htmlentities($result->PricePerDay);?>" required>
</div>
</div>


<div class="form-group">
<label class="col-sm-2 control-label">Data Wydania<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="movieyear" class="form-control" value="<?php echo htmlentities($result->MovieYear);?>" required>
</div>


<div class="form-group">
<label class="col-sm-2 control-label">Czas Trwania [min]<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="duration" class="form-control"value="<?php echo htmlentities($result->Duration);?>" required>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Aktorzy<span style="color:red">*</span></label>
<div class="col-sm-10">
<textarea class="form-control" name="actors" rows="2" required><?php echo htmlentities($result->Actors);?></textarea>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Reżyserzy<span style="color:red">*</span></label>
<div class="col-sm-6">
<input type="text" name="directors" class="form-control" value="<?php echo htmlentities($result->Directors);?>" required>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Kraj Produkcji<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="country" class="form-control" value="<?php echo htmlentities($result->Country);?>" required>
</div>
</div>


<div class="hr-dashed"></div>								
<div class="form-group">
<div class="col-sm-12">
<h4><b>Obrazy Filmu</b></h4>
</div>
</div>


<div class="form-group">
<div class="col-sm-4">
<img src="img/movieimages/<?php echo htmlentities($result->Vimage1);?>" width="200" height="300" style="border:solid 1px #000">
<a href="changeimage1.php?imgid=<?php echo htmlentities($result->id)?>">Zmień Obraz 1</a>
</div>
<div class="col-sm-4">
<?php if($result->Vimage2=="")
{
echo htmlentities("Nie można odnaleźć pliku");
} else {?>
<img src="img/movieimages/<?php echo htmlentities($result->Vimage2);?>" width="200" height="300" style="border:solid 1px #000">
<a href="changeimage2.php?imgid=<?php echo htmlentities($result->id)?>">Zmień Obraz 2</a>
<?php } ?>
</div>
<div class="col-sm-4">
<?php if($result->Vimage3=="")
{
echo htmlentities("Nie można odnaleźć pliku");
} else {?>
<img src="img/movieimages/<?php echo htmlentities($result->Vimage3);?>" width="200" height="300" style="border:solid 1px #000">
<a href="changeimage3.php?imgid=<?php echo htmlentities($result->id)?>">Zmień Obraz 3</a>
<?php } ?>
</div>
</div>


<div class="form-group">
<div class="col-sm-4">
<?php if($result->Vimage4=="")
{
echo htmlentities("Nie można odnaleźć pliku");
} else {?>
<img src="img/movieimages/<?php echo htmlentities($result->Vimage4);?>" width="200" height="300" style="border:solid 1px #000">
<a href="changeimage4.php?imgid=<?php echo htmlentities($result->id)?>">Zmień Obraz 4</a>
<?php } ?>

<?php if($result->Vimage5=="")
{
echo htmlentities("Nie można odnaleźć pliku");
} else {?>
<img src="img/movieimages/<?php echo htmlentities($result->Vimage5);?>" width="200" height="300" style="border:solid 1px #000">
<a href="changeimage5.php?imgid=<?php echo htmlentities($result->id)?>">Zmień Obraz 5</a>
<?php } ?>
</div>
</div>

<div class="hr-dashed"></div>									
</div>
</div>
</div>
</div>

<?php }} ?>


											<div class="form-group">
												<div class="col-sm-8 col-sm-offset-5" >
													
<button class="btn btn-primary" name="submit" type="submit" style="margin-top:4%">Zapisz</button>
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