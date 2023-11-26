<?php
session_start();
require_once "db.php";

if (isset($_SESSION['user_id']) != "") {
    header("Location: dashboard.php");
}

if (isset($_POST['register'])) {
    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Add validation checks similar to the login form

    // Check if the email already exists
    $check_query = "SELECT * FROM users WHERE email = '$email'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $error_message = "Email already exists. Please choose a different email.";
    } else {
        // Email doesn't exist, proceed with registration
        $hashed_password = md5($password);

        $query  = "INSERT INTO users(username, email, password) VALUES('$name', '$email', '$hashed_password')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $success_message = "Registration successful! You can now login.";
        } else {
            $error_message = "Error in registration. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Simple Registration Form in PHP | Tutsmake.com</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-10">
                <div class="page-header">
                    <h2>Registration Form in PHP</h2>
                </div>
                <p>Please fill all fields in the form</p>
                <span class="text-success"><?php if (isset($success_message)) echo $success_message; ?></span>
                <span class="text-danger"><?php if (isset($error_message)) echo $error_message; ?></span>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group ">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="" maxlength="30" required="">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="" maxlength="30" required="">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" value="" maxlength="20" required="">
                    </div>
                    <input type="submit" class="btn btn-primary" name="register" value="Register">
                    <br>
                    Already have an account?<a href="login.php" class="mt-3">Login Here</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
