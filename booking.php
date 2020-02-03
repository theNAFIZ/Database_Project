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
    $train_id = mysqli_real_escape_string($conn, $_GET['train_id']);
    $date = mysqli_real_escape_string($conn, $_GET['date']);
    $passenger = mysqli_real_escape_string($conn, $_GET['passenger']);
    $start = mysqli_real_escape_string($conn, $_GET['start']);
    $end = mysqli_real_escape_string($conn, $_GET['end']);
    
    $qf1 = mysqli_query($conn, "SELECT station_number from stations where station_id = '$start'");
    $qf2 = mysqli_query($conn, "SELECT station_number from stations where station_id = '$end'");

    $ss = mysqli_fetch_array($qf1);
    $es = mysqli_fetch_array($qf2);

    $fare = (int)$ss['station_number'] - (int)$es['station_number'];
	$fare = $fare * (int)$passenger;
	if($fare<0) {
		$fare = 0 - $fare;
	}

    $query1 = mysqli_query($conn, "SELECT t.train_id, s.station_id, t.train_name, s.station_name FROM trains t, stations s WHERE t.train_id = $train_id and t.start_station = s.station_id");
    $query2 = mysqli_query($conn, "SELECT s.station_name FROM trains t, stations s WHERE t.train_id = $train_id and t.end_station = s.station_id");
    $res2 = mysqli_fetch_array($query2);


    if(isset($_POST['reg'])) {
    	$q = "INSERT INTO booking (train_id, journey_date, user_id, tickets, fare) VALUES ('$train_id','$date', ".$_SESSION['user_id'].", $passenger, $fare);";
    	$ok = mysqli_query($conn, $q);
		if ($ok) {
			echo "<div><p class='btn-success col-lg-8 bottom'>SUCCESS</p></div>";
		} else{
			echo "<div><p class='btn-danger col-lg-8 bottom'>".mysqli_error($conn)."Failed"."</p></div>";
		}
    }

?>
<div class="wrapper">
	<div class="row">
		<div class="col-lg-3"></div>
		<h1 class="col-lg-5">Ticket Booking</h1>
		<button class="btn btn-warning btn-lg col-lg-1" onclick="window.location.href='logout.php'">Logout</button>
		<div class="col-lg-3"></div>
	</div>
	<div class="row">
		<div class="col-lg-8 box">
			<table class="table table-dark">
				<th>Train Name</th>
				<th>Departure Station</th>
				<th>Arrival Station</th>
				<th>No.of Persons</th>
				<th>Fare</th>
				<th>Confirm Booking</th>
				<?php
					echo '<tr>';
					while ($res = mysqli_fetch_array($query1)) {
						echo "<td>".$res['train_name']."</td>";
						echo "<td>".$res['station_name']."</td>";
						echo "<td>".$res2['station_name']."</td>";
						echo "<td>".$passenger."</td>";
						echo "<td>".$fare."</td>";
						echo '<td><form method ="POST"><input type="hidden" name="reg" value="1"><button type="input" class="btn btn-lg btn-danger">Confirm Booking</button></form></td>';
					}
					echo "</tr>";
				?>
			</table>
		</div>
	</div>
</div>
</body>

