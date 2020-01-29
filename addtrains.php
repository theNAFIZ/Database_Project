<?php include 'asset/include/header.php'; 
include 'asset/include/config.php'?>
<?php
	session_start();
	if(!isset($_SESSION['user_id'])) {
		header("Location: index.php");
    }
	$name = $number = $description  = "";
	$tickets = 0;

	if (isset($_POST["reg"])) {
		$name = mysqli_real_escape_string($conn, $_POST['name']);
		$number = mysqli_real_escape_string($conn, $_POST['number']);
		$tickets = (is_numeric($_POST['tickets']) ? (int)$_POST['tickets'] : 0);
		$description = mysqli_real_escape_string($conn, $_POST['description']);

		$query = "INSERT INTO trains(train_name, train_number, tickets, description) values ('$name', '$number', '$tickets', '$description');";
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
			<textarea rows="5" class="form-control" name="description" placeholder="Train Description"></textarea>
			<input type="submit" name="reg" value="Add Train!" class="btn btn-success btn-block btn-lg">
		</form>
	</div>
</div>
</body>