<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
if(isset($_REQUEST['eid']))
	{
$eid=intval($_GET['eid']);
$status="0";
$sql = "UPDATE tbltestimonial SET status=:status WHERE  id=:eid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':eid',$eid, PDO::PARAM_STR);
$query -> execute();

$msg="Testimonial Successfully Inacrive";
}


if(isset($_REQUEST['aeid']))
	{
$aeid=intval($_GET['aeid']);
$status=1;

$sql = "UPDATE tbltestimonial SET status=:status WHERE  id=:aeid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':aeid',$aeid, PDO::PARAM_STR);
$query -> execute();

$msg="Testimonial Successfully Active";
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

						<h2 class="page-title">Zarządzaj Opiniami</h2>

						<!-- Zero Configuration Table -->
						<div class="panel panel-default">
							<div class="panel-heading">Opinie Użytkowników</div>
							<div class="panel-body">
							<?php if($error){?><div class="errorWrap"><strong>Błąd </strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>Sukces </strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
								<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
										<th>#</th>
											<th>Imię i Nazwisko</th>
											<th>Email</th>
											<th>Opinia</th>
											<th>Data Wstawienia</th>
											<th>Akcja</th>
										</tr>
									</thead>
									<tfoot>
										<tr>
										<th>#</th>
											<th>Imię i Nazwisko</th>
											<th>Email</th>
											<th>Opinia</th>
											<th>Data Wstawienia</th>
											<th>Akcja</th>
										</tr>
									</tfoot>
									<tbody>

									<?php $sql = "SELECT tblusers.FullName,tbltestimonial.UserEmail,tbltestimonial.Testimonial,tbltestimonial.PostingDate,tbltestimonial.status,tbltestimonial.id from tbltestimonial join tblusers on tblusers.Emailid=tbltestimonial.UserEmail";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{				?>	
										<tr>
											<td><?php echo htmlentities($cnt);?></td>
											<td><?php echo htmlentities($result->FullName);?></td>
											<td><?php echo htmlentities($result->UserEmail);?></td>
											<td><?php echo htmlentities($result->Testimonial);?></td>
											<td><?php echo htmlentities($result->PostingDate);?></td>
										<td><?php if($result->status=="" || $result->status==0)
{
	?><a href="testimonials.php?aeid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Na pewno chcesz uaktywnić tę opinię?')">Nie Aktywowano</a>
<?php } else {?>

<a href="testimonials.php?eid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Na pewno chcesz aby ta opinia została nie aktywna?')">Aktywowano</a>
</td>
<?php } ?></td>
										</tr>
										<?php $cnt=$cnt+1; }} ?>
										
									</tbody>
								</table>

						

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
