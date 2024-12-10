<?php include("../inc/saAfterLoginHeader.php");
print_r($_SESSION);

if (isset($_SESSION['role']) || $_SESSION['role'] != "superadmin") {
    header("Location:../");
    exit;
}
?>

<h1>Super Admin ko Dash</h1>

<?php include("../inc/footer.php"); ?>