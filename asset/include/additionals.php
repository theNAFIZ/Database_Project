<?php
function typeChecker($integer) {
	if(!isset($_SESSION['user_id'])) {
		header("Location: index.php");
	} else if($_SESSION['type']==(int)$integer) {
		header("Location: dashboard.php");
	}
}


function stName($stat) {
	include 'asset/include/config.php';
	$query = mysqli_query($conn, "SELECT station_name FROM stations WHERE station_number = $stat");
	while($r = mysqli_fetch_array($query)) {
		return $r['station_name'];
	}
}
?>