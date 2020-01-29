<?php include 'asset/include/header.php';
include 'asset/include/config.php'; ?>
<div class="container col-md-3">
<?php
    session_start();
    $email = $pass = "";
    $errors = array();
    if(isset($_SESSION['user_id'])) {
         array_push($errors,'You are already logged in.');
         header("Location: Dashboard.php");
    }
    if (isset($_POST['sub'])) {
    #else {
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $pass = mysqli_real_escape_string($conn, $_POST['password']);
    }
    $sql = "SELECT user_id, access_type FROM users WHERE email = '".$email."' AND pass = '".$pass."'";
    if($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['user_id'];
            $type = $row['access_type'];

            if (!$id) {
                array_push($errors,"Login Failed.");
            }
            else {
                $_SESSION['user_id'] = $id;
                $_SESSION['type'] = $type;
                $_SESSION['timeout'] = time();
                if($_SESSION['type'] == 1) {
                    header("Location: Dashboard.php");
                } else {
                    header("Location: User_Dashboard.php");
                }
            }
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
            <input type="email" name="email" class="form-control" placeholder="Email address" required autofocus></input>
            <br>
            <label for="password" class="sr-only">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <input type="hidden" name="sub" value="1">
            <br>
            <input type="submit" name="reg" value="Login" class="btn btn-success btn-block btn-lg">
        </form>
        <br>
        <p class="mb-3"><a class="text-green" href="#">Forgot Password?</a></p>
        <p class="mb-3 text-white">Not regestered? <a class="text-success" href="signup.php">Create an account</a></p>
    </div>
</body>
</html>