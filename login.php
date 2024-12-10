<?php include("./inc/header.php");
include("./inc/db.php");
?>

<?php

if (isset($_POST['login'])) {
    try {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (strlen(trim($email)) < 1 || strlen(trim($password)) < 1) {
            throw new Exception("all fields are required");
        }

        $conn = getDB();
        $sql = "SELECT * FROM user WHERE email='$email'";

        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);


        if (password_verify($password, $user['password'])) {
            echo ("You have logged in!");
            $_SESSION['id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == "user") {
                header('Refresh: 2; URL=./user/home.php');
            } else {
                header('Refresh: 2; URL=./sa/dash.php');
            }
            exit;
        } else {
            throw new Exception("Failed to login, Try Again!");
        }
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}
?>

<link rel="stylesheet" href="assets/css/login.css" />

<form action="" method="post" class="loginFormContainer sectionContainer">
    <h1>Login Here...</h1>

    <div class="labelContainer">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Email...">
    </div>

    <div class="labelContainer">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Password...">
    </div>

    <button class="btn" type="submit" name="login">Login</button>

    <p class="loginTxt">
        Don't have account?
        <a href="./register.php">Create Account</a>
    </p>

</form>

<?php include("./inc/footer.php"); ?>