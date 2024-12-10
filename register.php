<?php
include("./inc/header.php");
include("./inc/db.php");
?>

<?php

if (isset($_POST['register'])) {
    try {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];


        if (strlen(trim($name)) < 1 || strlen(trim($email)) < 1 || strlen(trim($password)) < 1) {
            throw new Exception("all fields are required");
        }

        $password = password_hash($password, PASSWORD_DEFAULT);

        $conn = getDB();
        $sql = "INSERT INTO user (name, email, password) values ('$name', '$email', '$password');";

        $result = mysqli_query($conn, $sql);

        if (!$result) {
            throw new Exception("Failed to register, Try Again!");
        } else {
            echo ("You have registered, Please login now!");
            header('Refresh: 2; URL=./login.php');
            exit;
        }
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}

?>

<link rel="stylesheet" href="assets/css/login.css" />

<form action="" method="post" class="loginFormContainer sectionContainer">
    <h1>Register Here...</h1>

    <div class="labelContainer">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" placeholder="name...">
    </div>

    <div class="labelContainer">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Email...">
    </div>

    <div class="labelContainer">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Password...">
    </div>

    <button class="btn" type="submit" name="register">Register</button>

    <p class="loginTxt">
        Have account?
        <a href="./login.php">Login</a>
    </p>

</form>

<?php include("./inc/footer.php"); ?>