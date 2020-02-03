<?php include 'asset/include/header.php'; 
include 'asset/include/config.php'?>
<?php
	session_start();
	if(!isset($_SESSION['user_id'])) {
		header("Location: index.php");
    }else if($_SESSION['type']==0) {
    	header("Location: user_dashboard.php");
    }
    $sql = mysqli_query($conn, "SELECT * FROM stations ORDER BY station_name");
?>

<h1>Manage Station</h1>
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
			<th>Station Name</th>
			<th>Station Number</th>
			<th>Edit</th>
			<?php
				while ($res = mysqli_fetch_array($sql)) {
					echo "<tr>";
					echo "<td>".$res['station_name']."</td>";
					echo "<td>".$res['station_number']."</td>";
					echo "<td><a href='editstation.php?id=".$res['station_id']."'>Edit</a></td>";
					echo "</tr>";
				}
			?>
		</table>
	</div>
</div>
</body>