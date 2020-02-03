<?php include_once 'asset/include/header.php'; 
include_once 'asset/include/config.php'?>
<?php
	session_start();
	if(!isset($_SESSION['user_id'])) {
		header("Location: index.php");
    }
    else if($_SESSION['type']==0) {
    	header("Location: user_dashboard.php");
    }
    if(!isset($_GET['id'])) {
    	$_GET['id'] = 1;
    }
    $sql = mysqli_query($conn, "SELECT * FROM stations where station_id = ".$_GET['id']);
    $id = $_GET['id'];
    $res = mysqli_fetch_array($sql);
?>

<h1>Edit Station</h1>
<div class="wrapper row">
	<div class="col-lg-4">
		<ul  class="list-group">
			<li class="list-group-item"><a href="addtrains.php">Add Trains</a></li>
			<li class="list-group-item"><a href="addstations.php">Add Stations</a></li>
			<li class="list-group-item"><a href="addtimetables.php">Add Timetables</a></li>
			<li class="list-group-item"><a href="managetrains.php">Manage Trains</a></li>
			<li class="list-group-item"><a href="managestations.php">Manage Stations</a></li>
			<li class="list-group-item"><a href="managetimetables.php">Manage Timetables</a></li>
			<br>
			<li class="list-group-item"><a href="logout.php">Logout</a></li>
		</ul>
	</div>
	<div class="col-lg-6 box">

		<form method="POST">
			<input type="text" class="form-control" name="name" value="<?php echo $res['station_name']; ?>" required>
			<br>
			<input type="text" class="form-control" name="number"  value="<?php echo $res['station_number']; ?>"  required>
			<br>
			<textarea rows='5' class='form-control' name='description'><?php echo $res['description']; ?></textarea>
			<input type="hidden" name="sub" value="1">
			<input type="submit" class="btn btn-success btn-block btn-lg" name="reg" value="Edit This Station!">
		</form>
	</div>
</div>
<?php
	$name = $number = $description = "";
	$tickets = 0;
	if(isset($_POST['sub'])) {
		$name = mysqli_real_escape_string($conn, $_POST['name']);
		$number = mysqli_real_escape_string($conn, $_POST['number']);
		$description = mysqli_real_escape_string($conn, $_POST['description']);

		$query = "UPDATE stations SET station_name = '$name',station_number = '$number',  description = '$description' WHERE station_id = '$id';";
		$ok = mysqli_query($conn, $query);
		if ($ok) {
			header("Location: managestations.php");
		} else{
			echo "<div><p class='btn-danger bottom'>".mysqli_error($conn)."Failed"."</p></div>";
		}
	}
?>
</body>