<div class="container col-md-3">
<?php include 'asset/include/header.php';
include 'asset/include/config.php'; ?>
<?php
    session_start();
    $email = $pass = " ";
    $errors = array();
    if(isset($_SESSION['id'])) {
         array_push($errors,'You are already logged in.');
    }
    if (isset($_POST['reg'])) {
    #else {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $pass = mysqli_real_escape_string($conn, $_POST['password']);
        array_push($errors,"Data saved.");
    }
    $sql = "SELECT id FROM users WHERE email = '".$email."' AND password = '".$pass."'";
    if($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];

            if ($_SESSION["id"] == false) {
                array_push($errors,"Login Failed.");
            }

            $_SESSION['id'] = $id;
            $_SESSION['timeout'] = time();
            array_push($errors,"Logged in.");
            header("Location: Dashboard.php");
        }
    }
    include 'asset/include/errors.php';
?>

    
</div>
    <div class="container col-md-4 box">
        <div class="container logo">
            <img src="asset/img/logo.svg">
        </div>
        <h1 class="mb-3 font-weight-normal text-white">Login Form</h1>
        <form class="form-sign-in" action="index.php" method="POST">
            <label for="email" class="sr-only">Email</label>
            <input type="email" name="email" class="form-control" placeholder="Email address" required autofocus>
            <br>
            <label for="password" class="sr-only">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <br>
            <input type="submit" name="reg" class="btn btn-success btn-block btn-lg">Login</input>
        </form>
        <br>
        <p class="mb-3 text-white">Not regestered? <a class="text-success" href="signup.php">Create an account</a></p>
    </div>
</body>
</html>