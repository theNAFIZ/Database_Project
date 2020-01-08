<?php include 'asset/include/header.php';
include 'asset/include/config.php';
?>
<?php
session_start();
$email = $password = $password2 = $fname = $lname = $birth = "";
$errors = array();

if (isset($_POST["reg"])) {
	$fname = mysqli_real_escape_string($conn, $_POST['fname']);
	$lname = mysqli_real_escape_string($conn, $_POST['lname']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$birth = mysqli_real_escape_string($conn, $_POST['birth']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);
	$password2 = mysqli_real_escape_string($conn, $_POST['password2']);
	if (strlen($password) < 6) {
		array_push($errors, "Password is too short. Minimum 6 characters needed.");
	}
	if ($password != $password2) {
		array_push($errors, "Passwords don't match.");
	}
}

$user_check_sql = "SELECT * FROM USERS WHERE EMAIL= '$email' LIMIT 1";
$result = mysqli_query($conn, $user_check_sql);
$user = mysqli_fetch_assoc($result);

if ($user) {
	array_push($errors, "Email already exists. Please login.");
}
if (count($errors) == 0) {
	if($email != "") {
		$query = "INSERT INTO users (firstname, lastname, birth, email, password) values ('$fname', '$lname', '$birth', '$email', '$password');";
		$ok = mysqli_query($conn, $query);
		if ($ok) {
			echo "<p class='btn-success bottom'>SUCCESS</p>";
		} else{
			echo "<p class='btn-danger bottom'>".mysqli_error($conn)."</p>";
		}
	} else{
		array_push($errors, "Invalid entry. Please enter an email.");
	}
}

?>
<div class="container col-md-3 bottom">
    <?php include 'asset/include/errors.php' ?>
</div>
	<div class="container col-md-4 box">
		<div class="container logo">
            <img src="asset/img/logo.svg">
        </div>
		<form class="form-sign-in" method="POST" action="signup.php">
			<h1 class="font-weight-normal text-white">Create Account</h1>
			<input type="text" name="fname" placeholder="First Name" class="form-control" required autofocus>
			<br>
			<input type="text" name="lname" placeholder="Last Name" class="form-control">
			<br>
			<label for="date" class="sr-only">Birthdate</label>
			<input type="date" name="birth" placeholder="Date of birth" class="form-control" required>
			<br>
			<input type="email" name="email" placeholder="Email Address" class="form-control" required>
			<br>
			<input type="password" name="password" placeholder="Password" class="form-control" required>
			<br>
			<input type="password" name="password2" placeholder="Repeat Password" class="form-control" required>
			<br>
			<p style="text-align: left" class="text-white">By clicking Create account you agree to abide by our Terms of Service and Privacy Policy.</p>
			<input type="submit" class="btn btn-success btn-block btn-lg" name="reg">Create Account</input>
		</form>
		<br>
		<p class="mb-3 text-white">Already regestered? <a class="text-success" href="index.php">Log into your account</a></p>
	</div>
</body>