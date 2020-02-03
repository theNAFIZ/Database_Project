<?php include_once 'asset/include/header.php'; 
include_once 'asset/include/config.php'?>
<?php
	session_start();
	if(!isset($_SESSION['user_id'])) {
		header("Location: index.php");
    }else if($_SESSION['type']==0) {
    	header("Location: user_dashboard.php");
    }
    $sql = mysqli_query($conn, "SELECT * FROM Timetables where timetable_id = ".$_GET['id']);
    $id = $_GET['id'];
    $res = mysqli_fetch_array($sql);
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
			<input type="time" class="form-control" name="time" value="<?php echo $res['train_time']; ?>" required>
			<br>
			<input type="text" class="form-control" name="train_id" value="<?php echo $res['train_id']; ?>" required>
			<br>
			<input class="form-control" name="station_id" value="<?php echo $res['station_id']; ?>">
			<br>
			<input type="hidden" name="sub" value="1">
			<input type="submit" class="btn btn-success btn-block btn-lg" name="reg" value="Edit This Timetable!">
		</form>
	</div>
</div>
<?php
	$time = $train_id = $station_id = "";
	if(isset($_POST['sub'])) {
		$time = mysqli_real_escape_string($conn, $_POST['time']);
		$train_id = mysqli_real_escape_string($conn, $_POST['train_id']);
		$station_id = mysqli_real_escape_string($conn, $_POST['station_id']);
		$strtotime = strtotime($time);
		$train_time = date('H:m:s',$strtotime);
		$query = "UPDATE timetables SET train_time = '$train_time',train_id = '$train_id', station_id = '$station_id' WHERE timetable_id = '$id';";
		$ok = mysqli_query($conn, $query);
		if ($ok) {
			header("Location: managetimetables.php");
		} else{
			echo "<div><p class='btn-danger bottom'>".mysqli_error($conn)."Failed"."</p></div>";
		}
	}
?>
</body>