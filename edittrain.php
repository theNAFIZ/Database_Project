<?php include_once 'asset/include/header.php'; 
include_once 'asset/include/config.php'?>
<?php
	session_start();
	if(!isset($_SESSION['user_id'])) {
		header("Location: index.php");
    }else if($_SESSION['type']==0) {
    	header("Location: user_dashboard.php");
    }
    if(!isset($_GET['id'])) {
    	$_GET['id'] = 1;
    }
    $sql = mysqli_query($conn, "SELECT * FROM trains where train_id = ".$_GET['id']);
    $id = $_GET['id'];
    $res = mysqli_fetch_array($sql);

    $sqlStation = mysqli_query($conn, "SELECT * FROM stations ORDER BY station_name");
    $sqlSta = mysqli_query($conn, "SELECT * FROM stations ORDER BY station_name");
    $sta = mysqli_query($conn, "SELECT s.station_name, s.station_id FROM stations s, trains t WHERE t.start_station=s.station_id AND t.train_id = '$id'");
    $end = mysqli_query($conn, "SELECT s.station_name, s.station_id FROM stations s, trains t WHERE t.end_station=s.station_id AND t.train_id = '$id'");

?>

<h1>Add Train</h1>
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
			<label class="text-white" for="name">Train Name</label>
			<input type="text" class="form-control" name="name" value="<?php echo $res['train_name']; ?>" required>
			<br>
			<label class="text-white" for="id">Train id</label>
			<input type="text" class="form-control" name="id"  value="<?php echo $res['train_id']; ?>"  required>
			<br>
			<label class="text-white" for="tickets">No. of Tickets</label>
			<input type="text" class="form-control" name="tickets"  value="<?php echo $res['tickets']; ?>"  required>
			<br>
			<label class="text-white" for="from">Starting Station</label>
			<select class="form-control" name="from">
	        	<option disabled>Starting Station</option>
	        	<?php
	        	while ($starts = mysqli_fetch_array($sta)) {
	        		echo "<option selected value='".$starts["station_id"]."'>";
	        		echo $starts["station_name"];
	        		echo "</option>";
	        	}
	        	while ($resStation = mysqli_fetch_array($sqlStation)) {
	        		echo "<option value='".$resStation["station_id"]."'>";
	        		echo $resStation["station_name"];
	        		echo "</option>";
	        	}
	        	?>
	        </select>
	        <br>
	        <label class="text-white" for="to">Ending Station</label>
	        <select class="form-control" name="to">
	        	<option disabled>Ending Station</option>
	        	<?php
	        	while ($ends = mysqli_fetch_array($end)) {
	        		echo "<option selected value='".$ends["station_id"]."'>";
	        		echo $ends["station_name"];
	        		echo "</option>";
	        	}
	        	while ($res = mysqli_fetch_array($sqlSta)) {
	        		echo "<option value='".$res["station_id"]."'>";
	        		echo $res["station_name"];
	        		echo "</option>";
	        	}
	        	?>
	        </select>
			<br>
			<label class="text-white" for="description">Description</label>
			<textarea rows='5' class='form-control' name='description'><?php print_r($res['description']); ?></textarea>
			<input type="hidden" name="sub" value="1">
			<br>
			<input type="submit" class="btn btn-success btn-block btn-lg" name="reg" value="Edit This Train!">
		</form>
	</div>
</div>
<?php
	$name = $id = $description = "";
	$tickets = 0;
	if(isset($_POST['sub'])) {
		$name = mysqli_real_escape_string($conn, $_POST['name']);
		$id = mysqli_real_escape_string($conn, $_POST['id']);
		$tickets = (is_numeric($_POST['tickets']) ? (int)$_POST['tickets'] : 0);
		$description = mysqli_real_escape_string($conn, $_POST['description']);
		$start = mysqli_real_escape_string($conn, $_POST['from']);
		$end = mysqli_real_escape_string($conn, $_POST['to']);

		$query = "UPDATE trains SET train_name = '$name',train_id = '$id', tickets = '$tickets', description = '$description', start_station = '$start', end_station = '$end' WHERE train_id = '$id';";
		$ok = mysqli_query($conn, $query);
		if ($ok) {
			header("Location: managetrains.php");
		} else{
			echo "<div><p class='btn-danger bottom'>Failed. ".mysqli_error($conn)."</p></div>";
		}
	}
?>
</body>