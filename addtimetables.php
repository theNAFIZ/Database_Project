<?php include 'asset/include/header.php'; 
include 'asset/include/config.php'?>
<?php
	session_start();
	if(!isset($_SESSION['user_id'])) {
		header("Location: index.php");
    }else if($_SESSION['type']==0) {
    	header("Location: user_dashboard.php");
    }
	$time = $train_id = $station_id  = "";

	if (isset($_POST["reg"])) {
		$time = mysqli_real_escape_string($conn, $_POST['time']);
		$train_id = mysqli_real_escape_string($conn, $_POST['train_id']);
		$station_id = mysqli_real_escape_string($conn, $_POST['station_id']);
		$strtotime = strtotime($time);
		$train_time = date('H:m:s',$strtotime);

		

		$query = "INSERT INTO timetables(train_time, train_id, station_id) values ('$train_time', '$train_id', '$station_id');";
		$ok = mysqli_query($conn, $query);
		if ($ok) {
			echo "<div><p class='btn-success bottom'>SUCCESS</p></div>";
		} else{
			echo "<div><p class='btn-danger bottom'>".mysqli_error($conn)."Failed"."</p></div>";
		}

	}
	$sqlSta = mysqli_query($conn, "SELECT * FROM stations ORDER BY station_name");
	$sqlTra = mysqli_query($conn, "SELECT * FROM trains ORDER BY train_name");
?>
<h1>Add Timetable</h1>
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
	<div class="col-lg-8">
		<form action="addtimetables.php" method="POST">
			<input type="time" class="form-control" name="time" placeholder="Time" required>
			<br>
			<select class="form-control" name="train_id">
	        	<option selected disabled>Train Name</option>
	        	<?php
	        	while ($resTrain = mysqli_fetch_array($sqlTra)) {
	        		echo "<option value='".$resTrain["train_id"]."'>";
	        		echo $resTrain["train_name"];
	        		echo "</option>";
	        	}
	        	?>
	        </select>
			<br>
			<select class="form-control" name="station_id">
	        	<option selected disabled>Station Name</option>
	        	<?php
	        	while ($resStation = mysqli_fetch_array($sqlSta)) {
	        		echo "<option value='".$resStation["station_id"]."'>";
	        		echo $resStation["station_name"];
	        		echo "</option>";
	        	}
	        	?>
	        </select>
			<br>
			<input type="submit" name="reg" value="Add Timetable" class="btn btn-success btn-block btn-lg">
		</form>
	</div>
</div>
</body>