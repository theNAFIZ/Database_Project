<?php include 'asset/include/header.php'; 
include 'asset/include/config.php'?>
<?php
	session_start();
	if(!isset($_SESSION['user_id'])) {
		header("Location: index.php");
    } else if($_SESSION['type']==1) {
    	header("Location: dashboard.php");
    }
?>
<div class="wrapper">
	<h1>User Dashboard</h1>
	<div class="wrapper col-lg-4">
		
	</div>
</div>
</body>