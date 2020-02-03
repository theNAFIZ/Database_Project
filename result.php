<?php include 'asset/include/header.php'; 
include 'asset/include/config.php'?>
<?php
	session_start();
	if(!isset($_SESSION['user_id'])) {
		header("Location: index.php");
    }else if($_SESSION['type']==0) {
    	header("Location: user_dashboard.php");
    }
    $fr = $_POST['from'];
    $to = $_POST['to'];
    $sql = mysqli_query($conn, "SELECT t.train_name FROM trains t,stations s WHERE t.start_station BETWEEN $fr and $to AND t.end_station BETWEEN $fr and $to");
?>

<h1>Available Trains</h1>
<div class="wrapper">
	<div class="col-lg-8 box">
		<table class="table table-dark" border="1">
			<th>Train Name</th>
			<th>Train Number</th>
			<th>Time</th>
			<?php
				while ($res = mysqli_fetch_array($sql)) {
					echo "<tr>";
					echo "<td>".$res['train_name']."</td>";
					echo "<td>".$res['train_number']."</td>";
					echo "<td><a href='booking.php?id=".$res['train_id']."'>Purchase</a></td>";
					echo "</tr>";
				}
			?>
		</table>
	</div>
</div>
</body>