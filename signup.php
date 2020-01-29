<?php include 'asset/include/header.php';
include 'asset/include/config.php';
?>
<?php
session_start();
$name = $fname = $lname = $birth = $email = $contact = $password = $password2  = $sec_ans  = " ";
$sec_que = 0;
$errors = array();

if (isset($_POST['sub'])) {
	$fname = mysqli_real_escape_string($conn, $_POST['fname']);
	$lname = mysqli_real_escape_string($conn, $_POST['lname']);
	$birth = mysqli_real_escape_string($conn, $_POST['birth']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$contact = mysqli_real_escape_string($conn, $_POST['contact']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);
	$password2 = mysqli_real_escape_string($conn, $_POST['password2']);
	$sec_que = (is_numeric($_POST['sec_ques']) ? (int)$_POST['sec_ques'] : 0);
	$sec_ans = mysqli_real_escape_string($conn, $_POST['sec_ans']);
	$name = $fname ." ".$lname;

	if (strlen($password) < 6) {
		array_push($errors, "Password is too short. Minimum 6 characters needed.");
	}
	if ($password != $password2) {
		array_push($errors, "Passwords don't match.");
	}
	if($sec_que == 0) {
		array_push($errors, "Please select a security question.");
	}

	$user_check_sql = "SELECT * FROM USERS WHERE EMAIL= '$email' LIMIT 1";
	$result = mysqli_query($conn, $user_check_sql);
	$user = mysqli_fetch_assoc($result);

	if ($user) {
		array_push($errors, "Email already exists. Please login.");
	}
	if (count($errors) == 0) {
		$query = "INSERT INTO users (name, birthdate, email, contact, pass, sec_que, sec_ans) values ('$name', '$birth', '$email', '$contact', '$password', $sec_que, '$sec_ans');";
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
			<input type="date" name="birth" placeholder="Date of birth" class="form-control" required>
			<br>
			<input type="email" name="email" placeholder="Email Address" class="form-control" required>
			<br>
			<input type="password" name="password" placeholder="Password" class="form-control" required>
			<br>
			<input type="password" name="password2" placeholder="Repeat Password" class="form-control" required>
			<input type="hidden" name="sub" value="1" />
			<br>
			<input type="text" name="contact" placeholder="Contact Number" class="form-control" required>
			<br>
			<select class="form-control" name="sec_ques" required>
				<option selected disabled>Select Security Question from below: </option>
    			<option value="1">What was the house number and street name you lived in as a child?</option>
				<option value="2">What were the last four digits of your childhood telephone number?</option>
				<option value="3">What primary school did you attend?</option>
				<option value="4">In what town or city was your first full time job?</option>
				<option value="5">In what town or city did you meet your spouse/partner?</option>
				<option value="6">What is the middle name of your oldest child?</option>
				<option value="7">What are the last five digits of your driver's licence number?</option>
				<option value="8">What is your grandmother's (on your mother's side) maiden name?</option>
				<option value="9">What is your spouse or partner's mother's maiden name?</option>
				<option value="10">In what town or city did your mother and father meet?</option>
  			</select>
			<br>
			<input type="text" name="sec_ans" placeholder="Security Question Answer" class="form-control" required>
			<br>
			<p style="text-align: left" class="text-white">By clicking Create account you agree to 
			abide by our Terms of Service and Privacy Policy.</p>
			<input type="submit" value="Create Account" class="btn btn-success btn-block btn-lg">
		</form>
		<br>
		<p class="mb-3 text-white">Already regestered? <a class="text-success" href="index.php">Log into your account</a></p>
	</div>
</body>