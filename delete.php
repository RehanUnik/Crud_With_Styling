<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "mydb2";
$conn = mysqli_connect($servername, $username, $password, $db);
if (!$conn) {
    die("Failed: " . mysqli_connect_error());
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM users WHERE id='$id'";
    if (mysqli_query($conn, $sql)) {
        header("Location: add.php");
    } else {
        echo "Error " . mysqli_error($conn);
    }
}


mysqli_close($conn);
