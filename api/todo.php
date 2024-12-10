<?php
include("../inc/db.php");
session_start();

$currentUser = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $sql = "SELECT * FROM todo WHERE user_id = '$currentUser';";
    $conn = getDB();
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        echo "Failed to get Value";
        exit;
    }
    $todos = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($todos);
}
