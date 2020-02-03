<?php include 'asset/include/header.php'; 
include 'asset/include/config.php'?>
<?php
	session_start();
	if(!isset($_SESSION['user_id'])) {
		header("Location: index.php");
    }
	$name = $number = $description  = "";
	$tickets = $start = $end = 0;
	$sqlStation = mysqli_query($conn, "SELECT * FROM stations ORDER BY station_name");
    $sqlSta = mysqli_query($conn, "SELECT * FROM stations ORDER BY station_name");
	if (isset($_POST["reg"])) {
		$name = mysqli_real_escape_string($conn, $_POST['name']);
		$number = mysqli_real_escape_string($conn, $_POST['number']);
		$tickets = (is_numeric($_POST['tickets']) ? (int)$_POST['tickets'] : 0);
		$description = mysqli_real_escape_string($conn, $_POST['description']);
		$start = (is_numeric($_POST['from']) ? (int)$_POST['from'] : 0);
		$end = (is_numeric($_POST['to']) ? (int)$_POST['to'] : 0);

		$query = "INSERT INTO trains(train_name, train_number, tickets, description, start_station, end_station) values ('$name', '$number', '$tickets', '$description', '$start', '$end');";
		$ok = mysqli_query($conn, $query);
		if ($ok) {
			echo "<div><p class='btn-success bottom'>SUCCESS</p></div>";
		} else{
			echo "<div><p class='btn-danger bottom'>".mysqli_error($conn)."Failed"."</p></div>";
		}

	}
?>

<h1>Add Train</h1>
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
		<form action="addtrains.php" method="POST">
			<input type="text" class="form-control" name="name" placeholder="Train Name" required>
			<br>
			<input type="text" class="form-control" name="number" placeholder="Train Number" required>
			<br>
			<input type="text" class="form-control" name="tickets" placeholder="Tickets" required>
			<br>
			<select class="form-control" name="from">
	        	<option selected disabled>Starting Station</option>
	        	<?php
	        	while ($resStation = mysqli_fetch_array($sqlStation)) {
	        		echo "<option value='".$resStation["station_id"]."'>";
	        		echo $resStation["station_name"];
	        		echo "</option>";
	        	}
	        	?>
	        </select>
	        <br>
	        <select class="form-control" name="to">
	        	<option selected disabled>Ending Station</option>
	        	<?php
	        	while ($res = mysqli_fetch_array($sqlSta)) {
	        		echo "<option value='".$res["station_id"]."'>";
	        		echo $res["station_name"];
	        		echo "</option>";
	        	}
	        	?>
	        </select>
	        <br>
			<textarea rows="5" class="form-control" name="description" placeholder="Train Description"></textarea>
			<br>
			<input type="submit" name="reg" value="Add Train!" class="btn btn-success btn-block btn-lg">
		</form>
	</div>
</div>
</body>