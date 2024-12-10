<?php

session_start();
$_SESSION['id'] = '';
$_SESSION['email'] = '';
$_SESSION['name'] = '';
$_SESSION['role'] = '';
session_unset();
header("Location:./login.php");
