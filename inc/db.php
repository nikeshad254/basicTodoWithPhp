<?php

function getDB()
{
    $conn = mysqli_connect("localhost", "root", "", "todo");
    if (!$conn) {
        die("Connection Failed.");
    }
    return $conn;
}
