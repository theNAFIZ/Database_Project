<?php include 'asset/include/header.php'; 
include 'asset/include/config.php'?>
<?php
	session_start();
	if(!isset($_SESSION['user_id'])) {
		header("Location: index.php");
    }
    $sql = mysqli_query($conn, "SELECT * FROM trains ORDER BY train_name");
?>

<h1>Manage Train</h1>
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
		<table class="table table-dark" border="1">
			<th>Train Name</th>
			<th>Train id</th>
			<th>Tickets</th>
			<th>Start Station</th>
			<th>End Station</th>
			<th>Edit</th>
			<?php
				while ($res = mysqli_fetch_array($sql)) {
					echo "<tr>";
					echo "<td>".$res['train_name']."</td>";
					echo "<td>".$res['train_id']."</td>";
					echo "<td>".$res['tickets']."</td>";
					echo "<td>".stName($res['start_station'])."</td>";
					echo "<td>".stName($res['end_station'])."</td>";
					echo "<td><a href='edittrain.php?id=".$res['train_id']."'>Edit</a></td>";
					echo "</tr>";
				}
			?>
		</table>
	</div>
</div>
</body>
<?php
function stName($stat) {
	include 'asset/include/config.php';
	$query = mysqli_query($conn, "SELECT station_name FROM stations WHERE station_id = $stat");
	while($r = mysqli_fetch_array($query)) {
		return $r['station_name'];
	}
}
?>