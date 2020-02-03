<?php
include 'asset/include/header.php'; 
include 'asset/include/config.php';
?>
<?php
	session_start();
	if(!isset($_SESSION['user_id'])) {
		header("Location: index.php");
    } else if($_SESSION['type']==1) {
    	header("Location: dashboard.php");
    }
    $sqlStation = mysqli_query($conn, "SELECT * FROM stations ORDER BY station_name");
    $sqlSta = mysqli_query($conn, "SELECT * FROM stations ORDER BY station_name");

?>
<div class="wrapper">
	<div class="row">
		<div class="col-lg-3"></div>
		<h1 class="col-lg-5">User Dashboard</h1>
		<button class="btn btn-warning btn-lg col-lg-1" onclick="window.location.href='logout.php'">Logout</button>
		<div class="col-lg-3"></div>
	</div>
	<div class="row">
		<div class="col-lg-6 box">
			<form class="form-submit" method="GET">
		        <select class="form-control" name="from">
		        	<option selected disabled>From</option>
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
		        	<option selected disabled>To</option>
		        	<?php
		        	while ($res = mysqli_fetch_array($sqlSta)) {
		        		echo "<option value='".$res["station_id"]."'>";
		        		echo $res["station_name"];
		        		echo "</option>";
		        	}
		        	?>
		        </select>
		        <br>
		        <input class="form-control" type="date" name="date" placeholder="Date">
		        <br>
		        <input class="form-control" type="text" name="passenger" placeholder="Number of Passengers">
		        <br>
		        <input type="hidden" name="reg" value="1">
		        <input type="submit" value="Find Train" class="btn btn-lg btn-success form-control">
	    	</form>
		</div>
	</div>
	<?php
	include 'asset/include/config.php';
	if(isset($_GET["reg"])) {
		echo '<div class="col-lg-8 box">';
		$from = $_GET['from'];
		$to = $_GET['to'];
		$date = $_GET['date'];
		$passenger = $_GET['passenger'];
		$query = mysqli_query($conn, "SELECT * FROM trains WHERE (start_station BETWEEN $from AND $to) AND (end_station BETWEEN $from AND $to)");
		if(mysqli_num_rows($query) >0) {
			echo "<table class='table table-dark' border = '1'><th>Train Name</th><th>Train Time</th>";
			while ($results = mysqli_fetch_array($query)) {
				echo "<tr><td>".$results['train_name']."</td><td>".timeTr($from, $results['train_id'])."</td>";
				echo "<td><a href='booking.php?train_id={$results['train_id']}&date={$date}&passenger={$passenger}&start={$from}&end={$to}'>Details</a></td><?tr>";
			}
			echo "</table>";
		} else {
			echo "<p class='text-white'>No results found.</p>";
		}
		echo "</div>";
	}
	function stName($stat) {
		include 'asset/include/config.php';
		$query = mysqli_query($conn, "SELECT station_name FROM stations WHERE station_id = $stat LIMIT 1");
		while($r = mysqli_fetch_array($query)) {
			return $r['station_name'];
		}
	}
	function timeTr($sta,$tra) {
		include 'asset/include/config.php';
		$query = mysqli_query($conn, "SELECT train_time FROM timetables WHERE train_id = $tra AND station_id = $sta LIMIT 1");
		while($r = mysqli_fetch_array($query)) {
			return $r['train_time'];
		}
	}
?>
</div>
</body>

