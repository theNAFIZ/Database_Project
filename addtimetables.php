<?php include 'asset/include/header.php'; 
include 'asset/include/config.php'?>
<?php
	session_start();
	if(!isset($_SESSION['user_id'])) {
		header("Location: index.php");
    }
	$time = $train_number = $station_number  = "";

	if (isset($_POST["reg"])) {
		$train_time = mysqli_real_escape_string($conn, $_POST['time']);
		$train_n = mysqli_real_escape_string($conn, $_POST['train_number']);
		$station_n = mysqli_real_escape_string($conn, $_POST['station_number']);

		$query = "INSERT INTO timetables(train_time, train_number, station_number) values ('$time', '$train_n', '$station_n');";
		$ok = mysqli_query($conn, $query);
		if ($ok) {
			echo "<div><p class='btn-success bottom'>SUCCESS</p></div>";
		} else{
			echo "<div><p class='btn-danger bottom'>".mysqli_error($conn)."Failed"."</p></div>";
		}

	}
?>
<h1>Add Timetable</h1>
<div class="wrapper row">
	<div class="col-lg-4">
		<ul  class="list-group">
			<li class="list-group-item"><a href="addtrains.php">Add Trains</a></li>
			<li class="list-group-item"><a href="addstations.php">Add Stations</a></li>
			<li class="list-group-item"><a href="managetrains.php">Manage Trains</a></li>
			<li class="list-group-item"><a href="managestations.php">Manage Stations</a></li>
			<li class="list-group-item"><a href="addtimetables.php">Add Timetables</a></li>
			<li class="list-group-item"><a href="managetimetables.php">Manage Timetables</a></li>
			<br>
			<li class="list-group-item"><a href="logout.php">Logout</a></li>
		</ul>
	</div>
	<div class="col-lg-8">
		<form action="addtimetables.php" method="POST">
			<input type="time" class="form-control" name="time" placeholder="Time" required>
			<br>
			<input type="text" class="form-control" name="train_number" placeholder="Train Number" required>
			<br>
			<input class="form-control" name="station_number" placeholder="Station Number">
			<br>
			<input type="submit" name="reg" value="Add Timetable" class="btn btn-success btn-block btn-lg">
		</form>
	</div>
</div>
</body>