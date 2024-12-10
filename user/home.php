<?php
include("../inc/userAfterLoginHeader.php");

if (isset($_SESSION['role']) || $_SESSION['role'] != "user") {
    header("Location:../");
    exit;
}
?>


<h1>user ko Home</h1>

<?php include("../inc/footer.php"); ?>